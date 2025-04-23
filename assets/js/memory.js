class MemoryGame {
    constructor() {
        this.cards = [];
        this.flippedCards = [];
        this.matchedPairs = 0;
        this.moves = 0;
        this.score = 0;
        this.timer = 0;
        this.timerInterval = null;
        this.level = 1;
        this.isPlaying = false;
        this.difficulty = 'medium'; // Default difficulty

        this.init();
    }

    init() {
        // Show difficulty selection screen
        const difficultySelect = document.querySelector('.difficulty-select');
        const container = document.querySelector('.container');
        
        // Handle difficulty selection
        document.querySelectorAll('.difficulty-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                this.difficulty = btn.dataset.difficulty;
                difficultySelect.style.display = 'none';
                container.style.display = 'block';
                this.loadLevel();
                this.startTimer();
                this.isPlaying = true;
            });
        });
    }

    loadLevel() {
        const grid = document.querySelector('.memory-grid');
        grid.innerHTML = '';
        
        // Set grid columns based on difficulty
        switch(this.difficulty) {
            case 'easy':
                grid.style.gridTemplateColumns = 'repeat(4, 1fr)';
                grid.style.gridTemplateRows = 'repeat(2, 1fr)';
                this.cards = this.generateCards(4); // 4 pairs for easy
                break;
            case 'medium':
                grid.style.gridTemplateColumns = 'repeat(4, 1fr)';
                this.cards = this.generateCards(8); // 8 pairs for medium
                break;
            case 'hard':
                grid.style.gridTemplateColumns = 'repeat(6, 1fr)';
                this.cards = this.generateCards(12); // 12 pairs for hard
                break;
        }

        // Shuffle and create cards
        this.shuffleCards();
        this.cards.forEach(card => {
            const cardElement = this.createCardElement(card);
            grid.appendChild(cardElement);
        });
    }

    generateCards(pairs) {
        const cards = [];
        const teddyImages = [
            'pink-princess.png',
            'blue-strawberry.png',
            'strawberry.png',
            'cotton-candy.png',
            'honey.png',
            'rainbow.png',
            'gummy.png',
            'cupcake.png',
            'golden-unicorn.png'
        ];

        // Create pairs of cards
        for (let i = 0; i < pairs; i++) {
            const imageIndex = i % teddyImages.length;
            const cardId = i;
            
            // Create first card of the pair
            cards.push({
                id: cardId,
                image: teddyImages[imageIndex],
                matched: false
            });
            
            // Create second card of the pair
            cards.push({
                id: cardId,
                image: teddyImages[imageIndex],
                matched: false
            });
        }

        return cards;
    }

    shuffleCards() {
        for (let i = this.cards.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [this.cards[i], this.cards[j]] = [this.cards[j], this.cards[i]];
        }
    }

    createCardElement(card) {
        const cardElement = document.createElement('div');
        cardElement.className = 'memory-card';
        cardElement.dataset.id = card.id;
        cardElement.dataset.image = card.image;

        const front = document.createElement('div');
        front.className = 'memory-card-front';
        const img = document.createElement('img');
        img.src = `assets/img/${card.image}`;
        img.alt = 'Gấu bông';
        front.appendChild(img);

        const back = document.createElement('div');
        back.className = 'memory-card-back';

        cardElement.appendChild(front);
        cardElement.appendChild(back);

        cardElement.addEventListener('click', () => this.flipCard(cardElement));

        return cardElement;
    }

    flipCard(cardElement) {
        if (!this.isPlaying || this.flippedCards.length >= 2 || 
            cardElement.classList.contains('flipped') || 
            cardElement.classList.contains('matched')) {
            return;
        }

        cardElement.classList.add('flipped');
        this.flippedCards.push(cardElement);

        if (this.flippedCards.length === 2) {
            this.moves++;
            this.updateMoves();
            this.checkMatch();
        }
    }

    checkMatch() {
        const [card1, card2] = this.flippedCards;
        const match = card1.dataset.id === card2.dataset.id;

        if (match) {
            this.handleMatch(card1, card2);
        } else {
            this.handleMismatch(card1, card2);
        }
    }

    handleMatch(card1, card2) {
        card1.classList.add('matched');
        card2.classList.add('matched');
        this.matchedPairs++;
        this.score += 10;
        this.updateScore();

        this.flippedCards = [];

        if (this.matchedPairs === this.cards.length / 2) {
            this.handleLevelComplete();
        }
    }

    handleMismatch(card1, card2) {
        setTimeout(() => {
            card1.classList.remove('flipped');
            card2.classList.remove('flipped');
            this.flippedCards = [];
        }, 1000);
    }

    handleLevelComplete() {
        this.isPlaying = false;
        clearInterval(this.timerInterval);
        
        const levelComplete = document.querySelector('.level-complete');
        const finalTime = document.querySelector('.final-time');
        const finalMoves = document.querySelector('.final-moves');
        const finalScore = document.querySelector('.final-score');
        const newTeddy = document.querySelector('.new-teddy img');

        finalTime.textContent = this.formatTime(this.timer);
        finalMoves.textContent = this.moves;
        finalScore.textContent = this.score;

        // Show new teddy if available
        const nextTeddyIndex = this.level % 9;
        newTeddy.src = `assets/img/${this.cards[nextTeddyIndex].image}`;
        newTeddy.alt = 'Gấu bông mới';

        // Add experience points based on difficulty
        let expGained = 0;
        switch(this.difficulty) {
            case 'easy':
                expGained = 5;
                break;
            case 'medium':
                expGained = 10;
                break;
            case 'hard':
                expGained = 15;
                break;
        }

        // Update experience in localStorage
        const currentExp = parseInt(localStorage.getItem('experience') || '0');
        const newExp = currentExp + expGained;
        localStorage.setItem('experience', newExp.toString());

        // Show experience gained
        const expMessage = document.createElement('p');
        expMessage.className = 'exp-gained';
        expMessage.textContent = `+${expGained} EXP`;
        document.querySelector('.level-complete-content').insertBefore(
            expMessage,
            document.querySelector('.next-level')
        );

        levelComplete.style.display = 'flex';
        confetti();

        // Save progress
        this.saveProgress();
    }

    startTimer() {
        this.timerInterval = setInterval(() => {
            this.timer++;
            this.updateTimer();
        }, 1000);
    }

    updateTimer() {
        const timerElement = document.querySelector('.timer');
        timerElement.textContent = `Thời gian: ${this.formatTime(this.timer)}`;
    }

    updateMoves() {
        const movesElement = document.querySelector('.moves');
        movesElement.textContent = `Lượt: ${this.moves}`;
    }

    updateScore() {
        const scoreElement = document.querySelector('.current-score');
        scoreElement.textContent = `Điểm: ${this.score}`;
    }

    formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
    }

    saveProgress() {
        const progress = {
            level: this.level,
            score: this.score,
            unlockedTeddies: this.level
        };
        localStorage.setItem('memoryProgress', JSON.stringify(progress));
    }

    loadProgress() {
        const progress = JSON.parse(localStorage.getItem('memoryProgress'));
        if (progress) {
            this.level = progress.level;
            this.score = progress.score;
        }
    }

    handleBackToSelect() {
        const transition = document.querySelector('.game-transition');
        transition.style.display = 'flex';
        transition.style.opacity = '1';
        transition.querySelector('.game-transition-text').textContent = 'Đang rời game...';
        
        setTimeout(() => {
            window.location.href = 'index.html';
        }, 1000);
    }
}

// Initialize game when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const game = new MemoryGame();

    // Handle next level button
    document.querySelector('.next-level').addEventListener('click', () => {
        game.level++;
        game.matchedPairs = 0;
        game.moves = 0;
        game.timer = 0;
        game.isPlaying = true;
        game.loadLevel();
        game.startTimer();
        document.querySelector('.level-complete').style.display = 'none';
    });

    // Handle back button
    document.querySelector('.back-to-select').addEventListener('click', () => {
        game.handleBackToSelect();
    });
}); 