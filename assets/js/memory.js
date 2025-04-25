class MemoryGame {
    constructor() {
        this.cards = [];
        this.flippedCards = [];
        this.matchedPairs = 0;
        this.moves = 0;
        this.score = 0;
        this.timer = 30; // 30 seconds timer
        this.timerInterval = null;
        this.level = 1;
        this.isPlaying = false;
        this.difficulty = 'medium'; // Default difficulty
        this.consecutiveMatches = 0; // Track consecutive matches
        this.playerName = this.getPlayerName(); // Get player name from localStorage

        // Show initial transition
        const transition = document.querySelector('.game-transition');
        transition.style.display = 'flex';
        transition.style.opacity = '1';
        transition.querySelector('.game-transition-text').textContent = 'Đang vào game...';

        // Hide difficulty selection initially
        const difficultySelect = document.querySelector('.difficulty-select');
        difficultySelect.style.display = 'none';

        setTimeout(() => {
            // Hide transition
            transition.style.opacity = '0';
            setTimeout(() => {
                transition.style.display = 'none';
                // Show difficulty selection
                difficultySelect.style.display = 'flex';
                this.init();
            }, 500);
        }, 1000);
    }

    getPlayerName() {
        return localStorage.getItem('playerName') || 'default';
    }

    init() {
        // Show difficulty selection screen
        const difficultySelect = document.querySelector('.difficulty-select');
        const container = document.querySelector('.container');
        
        // Add back button to difficulty selection
        const backButton = document.createElement('button');
        backButton.className = 'back-to-select';
        backButton.innerHTML = '<i class="fas fa-arrow-left"></i><span>Quay lại</span>';
        backButton.addEventListener('click', () => {
            const transition = document.querySelector('.game-transition');
            transition.style.display = 'flex';
            transition.style.opacity = '1';
            transition.style.zIndex = '9999';
            transition.querySelector('.game-transition-text').textContent = 'Đang rời game...';
            
            setTimeout(() => {
                window.location.href = 'index.html';
            }, 2000);
        });
        difficultySelect.appendChild(backButton);
        
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

        // Add back button functionality in game
        const gameBackButton = document.querySelector('.container .back-to-select');
        if (gameBackButton) {
            gameBackButton.addEventListener('click', () => {
                const transition = document.querySelector('.game-transition');
                transition.style.display = 'flex';
                transition.style.opacity = '1';
                transition.style.zIndex = '9999';
                transition.querySelector('.game-transition-text').textContent = 'Đang rời game...';
                
                setTimeout(() => {
                    window.location.href = 'index.html';
                }, 2000);
            });
        }
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
        const cardImages = [
            '1.png',
            '2.png',
            '3.png',
            '4.png',
            '5.png',
            '6.png',
            '7.png',
            '8.png',
            '9.png',
            '10.png',
            '11.png',
            '12.png'
        ];

        // Create pairs of cards
        for (let i = 0; i < pairs; i++) {
            const imageIndex = i % cardImages.length;
            const cardId = i;
            
            // Create first card of the pair
            cards.push({
                id: cardId,
                image: cardImages[imageIndex],
                matched: false
            });
            
            // Create second card of the pair
            cards.push({
                id: cardId,
                image: cardImages[imageIndex],
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
        img.alt = 'Cung hoang đạo';
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'contain';
        img.style.transform = 'scale(1.5)'; // Make image 50% bigger
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
        
        // Update consecutive matches and score
        this.consecutiveMatches++;
        if (this.consecutiveMatches >= 3) {
            // Bonus points for consecutive matches
            const bonusPoints = (this.consecutiveMatches - 2) * 5;
            this.score += 10 + bonusPoints; // Base 10 points + bonus
        } else {
            this.score += 10; // Base points for a match
        }
        
        this.updateScore();
        this.flippedCards = [];

        // Add time bonus for matching
        const timeBonus = 1; // 1 second bonus for each match
        this.timer += timeBonus;
        this.updateTimer();
        this.showTimeBonus(timeBonus);

        // Chance to get zodiac sign
        if (window.zodiacSystem && Math.random() < 0.2) { // 20% chance
            const zodiacId = Math.floor(Math.random() * 12) + 1;
            window.zodiacSystem.collectedZodiacs[zodiacId - 1]++;
            window.zodiacSystem.updateZodiacDisplay();
            window.zodiacSystem.saveData();
            window.zodiacSystem.showNotification(`Bạn đã nhận được ${window.zodiacSystem.zodiacSigns[zodiacId - 1].name}!`);
        }

        if (this.matchedPairs === this.cards.length / 2) {
            this.handleLevelComplete();
        }
    }

    showTimeBonus(bonus) {
        const timerElement = document.querySelector('.timer');
        const bonusElement = document.createElement('span');
        bonusElement.className = 'time-bonus';
        bonusElement.textContent = `+${bonus}s`;
        bonusElement.style.position = 'absolute';
        bonusElement.style.right = '0';
        bonusElement.style.top = '-20px';
        bonusElement.style.color = '#4CAF50';
        bonusElement.style.fontWeight = 'bold';
        bonusElement.style.fontSize = '1.2em';
        bonusElement.style.animation = 'timeBonus 1s ease-out forwards';
        
        timerElement.style.position = 'relative';
        timerElement.appendChild(bonusElement);
        
        setTimeout(() => {
            bonusElement.remove();
        }, 1000);
    }

    handleMismatch(card1, card2) {
        setTimeout(() => {
            card1.classList.remove('flipped');
            card2.classList.remove('flipped');
            this.flippedCards = [];
            this.consecutiveMatches = 0; // Reset consecutive matches on mismatch
        }, 1000);
    }

    handleLevelComplete() {
        this.isPlaying = false;
        clearInterval(this.timerInterval);
        
        const levelComplete = document.querySelector('.level-complete');
        const finalTime = document.querySelector('.final-time');
        const finalMoves = document.querySelector('.final-moves');
        const finalScore = document.querySelector('.final-score');

        finalTime.textContent = this.formatTime(this.timer);
        finalMoves.textContent = this.moves;
        finalScore.textContent = this.score;

        // Add experience points based on difficulty
        let expGained = 0;
        let coinsGained = 0;
        switch(this.difficulty) {
            case 'easy':
                expGained = 5;
                coinsGained = 5;
                if (this.timer > 15) {
                    coinsGained += 5;
                }
                break;
            case 'medium':
                expGained = 15;
                coinsGained = 10;
                if (this.timer > 20) {
                    coinsGained += 10;
                }
                break;
            case 'hard':
                expGained = 30;
                coinsGained = 15;
                if (this.timer > 30) {
                    coinsGained += 15;
                }
                break;
        }

        // Update experience in localStorage
        const currentExp = parseInt(localStorage.getItem('experience') || '0');
        const newExp = currentExp + expGained;
        localStorage.setItem('experience', newExp.toString());

        // Add coins to zodiac system
        if (window.zodiacSystem) {
            window.zodiacSystem.addMoney(coinsGained);
            currentGameState.moneyEarned += coinsGained;
        }

        // Check for zodiac card reward
        let zodiacReward = null;
        if (window.zodiacSystem) {
            const randomZodiac = window.zodiacSystem.zodiacSigns[Math.floor(Math.random() * window.zodiacSystem.zodiacSigns.length)];
            if (Math.random() < randomZodiac.rate) {
                window.zodiacSystem.collectedZodiacs[randomZodiac.id - 1]++;
                window.zodiacSystem.updateZodiacDisplay();
                window.zodiacSystem.saveData();
                zodiacReward = randomZodiac.name;
            }
        }

        // Show experience gained
        const expMessage = document.createElement('p');
        expMessage.className = 'exp-gained';
        expMessage.textContent = `+${expGained} EXP`;
        
        // Show coins gained
        const coinsMessage = document.createElement('p');
        coinsMessage.className = 'exp-gained';
        coinsMessage.textContent = `+${coinsGained} xu`;
        
        // Remove any existing exp message
        const existingExpMessage = document.querySelector('.exp-gained');
        if (existingExpMessage) {
            existingExpMessage.remove();
        }
        
        // Update the level complete content
        const levelCompleteContent = document.querySelector('.level-complete-content');
        levelCompleteContent.innerHTML = `
            <h2>Chúc mừng!</h2>
            <p>Bạn đã hoàn thành level!</p>
            <div class="stats">
                <p>Thời gian: <span class="final-time">${this.formatTime(this.timer)}</span></p>
                <p>Lượt: <span class="final-moves">${this.moves}</span></p>
                <p>Điểm: <span class="final-score">${this.score}</span></p>
            </div>
        `;
        
        // Add exp message after stats
        levelCompleteContent.appendChild(expMessage);
        
        // Add coins message after exp message
        levelCompleteContent.appendChild(coinsMessage);

        // Add zodiac reward message if any
        if (zodiacReward) {
            const zodiacMessage = document.createElement('p');
            zodiacMessage.className = 'exp-gained';
            zodiacMessage.textContent = `+${zodiacReward}`;
            levelCompleteContent.appendChild(zodiacMessage);
        }
        
        // Add play again button after all messages
        const playAgainButton = document.createElement('button');
        playAgainButton.className = 'play-again';
        playAgainButton.innerHTML = '<i class="fas fa-redo"></i> Chơi Lại';
        playAgainButton.addEventListener('click', () => {
            // Reset all game state
            this.matchedPairs = 0;
            this.moves = 0;
            this.score = 0;
            this.consecutiveMatches = 0;
            this.isPlaying = true;
            
            // Update UI
            document.querySelector('.moves').textContent = 'Lượt: 0';
            document.querySelector('.current-score').textContent = 'Điểm: 0';
            
            // Reload level and start timer
            this.loadLevel();
            this.startTimer();
            levelComplete.style.display = 'none';
        });
        levelCompleteContent.appendChild(playAgainButton);

        levelComplete.style.display = 'flex';
        confetti();

        // Save progress
        this.saveProgress();
    }

    startTimer() {
        // Set timer based on difficulty
        switch(this.difficulty) {
            case 'easy':
                this.timer = 30;
                break;
            case 'medium':
                this.timer = 45;
                break;
            case 'hard':
                this.timer = 60;
                break;
        }
        this.updateTimer();
        this.timerInterval = setInterval(() => {
            this.timer--;
            this.updateTimer();
            if (this.timer <= 0) {
                clearInterval(this.timerInterval);
                this.handleTimeUp();
            }
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

    handleTimeUp() {
        this.isPlaying = false;
        const levelComplete = document.querySelector('.level-complete');
        const levelCompleteContent = document.querySelector('.level-complete-content');
        
        // Update content for time up screen
        levelCompleteContent.innerHTML = `
            <h2>Hết thời gian!</h2>
            <p>Bạn đã không hoàn thành level!</p>
            <div class="stats">
                <p>Thời gian: <span class="final-time">00:00</span></p>
                <p>Lượt: <span class="final-moves">${this.moves}</span></p>
                <p>Điểm: <span class="final-score">${this.score}</span></p>
            </div>
        `;
        
        // Add play again button
        const playAgainButton = document.createElement('button');
        playAgainButton.className = 'play-again';
        playAgainButton.innerHTML = '<i class="fas fa-redo"></i> Chơi Lại';
        playAgainButton.addEventListener('click', () => {
            // Reset all game state
            this.matchedPairs = 0;
            this.moves = 0;
            this.score = 0;
            this.consecutiveMatches = 0;
            this.isPlaying = true;
            
            // Update UI
            document.querySelector('.moves').textContent = 'Lượt: 0';
            document.querySelector('.current-score').textContent = 'Điểm: 0';
            
            // Reload level and start timer
            this.loadLevel();
            this.startTimer();
            levelComplete.style.display = 'none';
        });
        levelCompleteContent.appendChild(playAgainButton);

        levelComplete.style.display = 'flex';
    }

    saveProgress() {
        const progress = {
            level: this.level,
            score: this.score,
            unlockedTeddies: this.level
        };
        localStorage.setItem(`memoryProgress_${this.playerName}`, JSON.stringify(progress));
    }

    loadProgress() {
        const progress = JSON.parse(localStorage.getItem(`memoryProgress_${this.playerName}`));
        if (progress) {
            this.level = progress.level;
            this.score = progress.score;
        }
    }

    handleBackToSelect() {
        const transition = document.querySelector('.game-transition');
        transition.style.display = 'flex';
        transition.style.opacity = '1';
        transition.style.zIndex = '9999';
        transition.querySelector('.game-transition-text').textContent = 'Đang rời game...';
        
        setTimeout(() => {
            window.location.href = 'index.html';
        }, 2000);
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
        game.timer = 60;
        game.isPlaying = true;
        game.loadLevel();
        game.startTimer();
        document.querySelector('.level-complete').style.display = 'none';
    });

    // Handle back button
    document.querySelector('.back-to-select').addEventListener('click', () => {
        game.handleBackToSelect();
    });

    // Update the level complete HTML structure
    const levelCompleteContent = document.querySelector('.level-complete-content');
    if (levelCompleteContent) {
        levelCompleteContent.innerHTML = `
            <h2>Chúc mừng!</h2>
            <p>Bạn đã hoàn thành level!</p>
            <div class="stats">
                <p>Thời gian: <span class="final-time">00:00</span></p>
                <p>Lượt: <span class="final-moves">0</span></p>
                <p>Điểm: <span class="final-score">0</span></p>
            </div>
            <button class="play-again">
                <i class="fas fa-redo"></i> Chơi Lại
            </button>
        `;
    }

    // Update the event listener for the play again button
    document.querySelector('.play-again').addEventListener('click', () => {
        game.matchedPairs = 0;
        game.moves = 0;
        game.timer = 60;
        game.isPlaying = true;
        game.loadLevel();
        game.startTimer();
        document.querySelector('.level-complete').style.display = 'none';
    });
}); 