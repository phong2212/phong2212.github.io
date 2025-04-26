class MemoryGame {
    constructor() {
        this.cards = [];
        this.flippedCards = [];
        this.matchedPairs = 0;
        this.moves = 0;
        this.score = 0;
        this.timer = 30;
        this.timerInterval = null;
        this.level = 1;
        this.isPlaying = false;
        this.difficulty = 'medium';
        this.consecutiveMatches = 0;
        this.playerName = this.getPlayerName();

        const transition = document.querySelector('.game-transition');
        transition.style.display = 'flex';
        transition.style.opacity = '1';
        transition.querySelector('.game-transition-text').textContent = 'Đang vào game...';

        const difficultySelect = document.querySelector('.difficulty-select');
        difficultySelect.style.display = 'none';

        setTimeout(() => {
            transition.style.opacity = '0';
            setTimeout(() => {
                transition.style.display = 'none';
                difficultySelect.style.display = 'flex';
                this.init();
            }, 500);
        }, 1000);
    }

    getPlayerName() {
        return localStorage.getItem('playerName') || 'default';
    }

    init() {
        const difficultySelect = document.querySelector('.difficulty-select');
        const container = document.querySelector('.container');

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

        const selectModeBtn = document.querySelector('.select-mode-btn');
        selectModeBtn.addEventListener('click', () => {
            if (this.isPlaying) {
                clearInterval(this.timerInterval);
                this.isPlaying = false;
                container.style.display = 'none';
                difficultySelect.style.display = 'flex';
            }
        });

        const exitGameBtn = document.querySelector('.exit-game');
        exitGameBtn.addEventListener('click', () => {
            this.handleBackToSelect();
        });

        const gameBackButton = document.querySelector('.container .back-to-select');
        if (gameBackButton) {
            gameBackButton.addEventListener('click', () => {
                this.handleBackToSelect();
            });
        }

        const difficultyBackButton = document.querySelector('.difficulty-header .back-to-select');
        if (difficultyBackButton) {
            difficultyBackButton.addEventListener('click', () => {
                this.handleBackToSelect();
            });
        }

        const levelCompleteExitGame = document.querySelector('.level-complete .exit-game');
        levelCompleteExitGame.addEventListener('click', () => {
            this.handleBackToSelect();
        });

        const timeUpExitGame = document.querySelector('.time-up .exit-game');
        timeUpExitGame.addEventListener('click', () => {
            this.handleBackToSelect();
        });
    }

    loadLevel() {
        const grid = document.querySelector('.memory-grid');
        grid.innerHTML = '';

        switch (this.difficulty) {
            case 'easy':
                grid.style.gridTemplateColumns = 'repeat(4, 1fr)';
                grid.style.gridTemplateRows = 'repeat(2, 1fr)';
                this.cards = this.generateCards(4);
                break;
            case 'medium':
                grid.style.gridTemplateColumns = 'repeat(4, 1fr)';
                this.cards = this.generateCards(8);
                break;
            case 'hard':
                grid.style.gridTemplateColumns = 'repeat(6, 1fr)';
                this.cards = this.generateCards(12);
                break;
        }

        this.shuffleCards();
        this.cards.forEach(card => {
            const cardElement = this.createCardElement(card);
            grid.appendChild(cardElement);
        });
    }

    generateCards(pairs) {
        const cards = [];
        const cardImages = [
            's1.png', 's2.png', 's3.png', 's4.png',
            's5.png', 's6.png', 's7.png', 's8.png',
            's9.png', 's10.png', 's11.png', 's12.png'
        ];

        for (let i = 0; i < pairs; i++) {
            const imageIndex = i % cardImages.length;
            const cardId = i;

            cards.push({ id: cardId, image: cardImages[imageIndex], matched: false });
            cards.push({ id: cardId, image: cardImages[imageIndex], matched: false });
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
        img.style.transform = 'scale(1.5)';
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
            cardElement.classList.contains('matched')) return;

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
        match ? this.handleMatch(card1, card2) : this.handleMismatch(card1, card2);
    }

    handleMatch(card1, card2) {
        card1.classList.add('matched');
        card2.classList.add('matched');
        this.matchedPairs++;
        this.consecutiveMatches++;

        this.score += 10 + Math.max(0, (this.consecutiveMatches - 2) * 5);
        this.updateScore();

        const timeBonus = 1;
        this.timer += timeBonus;
        this.updateTimer();
        this.showTimeBonus(timeBonus);

        if (window.zodiacSystem && Math.random() < 0.2) {
            const zodiacId = Math.floor(Math.random() * 12) + 1;
            window.zodiacSystem.collectedZodiacs[zodiacId - 1]++;
            window.zodiacSystem.updateZodiacDisplay();
            window.zodiacSystem.saveData();
            window.zodiacSystem.showNotification(`Bạn đã nhận được ${window.zodiacSystem.zodiacSigns[zodiacId - 1].name}!`);
        }

        this.flippedCards = [];

        // Check if all pairs are matched
        const totalPairs = this.cards.length / 2;
        if (this.matchedPairs === totalPairs) {
            this.handleLevelComplete();
        }
    }

    handleMismatch(card1, card2) {
        setTimeout(() => {
            card1.classList.remove('flipped');
            card2.classList.remove('flipped');
            this.flippedCards = [];
            this.consecutiveMatches = 0;
        }, 1000);
    }

    showTimeBonus(bonus) {
        const timerElement = document.querySelector('.timer');
        const bonusElement = document.createElement('span');
        bonusElement.className = 'time-bonus';
        bonusElement.textContent = `+${bonus}s`;
        bonusElement.style.cssText = `
            position: absolute;
            right: 0;
            top: -20px;
            color: #4CAF50;
            font-weight: bold;
            font-size: 1.2em;
            animation: timeBonus 1s ease-out forwards;
        `;

        timerElement.style.position = 'relative';
        timerElement.appendChild(bonusElement);
        setTimeout(() => bonusElement.remove(), 1000);
    }

    handleLevelComplete() {
        this.isPlaying = false;
        clearInterval(this.timerInterval);
        this.timerInterval = null;

        const levelComplete = document.querySelector('.level-complete');
        const finalTime = document.querySelector('.final-time');
        const finalMoves = document.querySelector('.final-moves');
        const finalScore = document.querySelector('.final-score');

        finalTime.textContent = this.formatTime(this.timer);
        finalMoves.textContent = this.moves;
        finalScore.textContent = this.score;

        // Add rewards based on difficulty
        let expReward = 0;
        let coinReward = 0;
        switch (this.difficulty) {
            case 'easy':
                expReward = 20;
                coinReward = 10;
                break;
            case 'medium':
                expReward = 40;
                coinReward = 20;
                break;
            case 'hard':
                expReward = 80;
                coinReward = 40;
                break;
        }

        // Save rewards to temporary storage
        localStorage.setItem('tempExp', expReward);
        localStorage.setItem('tempXu', coinReward);

        // Nút chơi lại
        const playAgainButton = levelComplete.querySelector('.play-again');
        if (playAgainButton) {
            playAgainButton.onclick = () => this.resetAndReplay(levelComplete);
        }

        // Update rewards display
        const rewardsDisplay = document.createElement('div');
        rewardsDisplay.className = 'rewards';
        rewardsDisplay.innerHTML = `
            <div class="exp-gained">+${expReward} EXP</div>
            <div class="coin-gained">+${coinReward} Xu</div>
        `;
        
        const levelCompleteButtons = levelComplete.querySelector('.level-complete-buttons');
        if (levelCompleteButtons) {
            levelCompleteButtons.insertBefore(rewardsDisplay, levelCompleteButtons.firstChild);
        }

        levelComplete.style.display = 'flex';
        confetti();
        this.saveProgress();
        this.isPlaying = false;
        clearInterval(this.timerInterval);
        this.timerInterval = null;
    }

    resetAndReplay(container) {
        // Ensure timer is completely stopped
        if (this.timerInterval) {
            clearInterval(this.timerInterval);
            this.timerInterval = null;
        }

        this.isPlaying = false;

        // Hide game container and show difficulty selection
        const gameContainer = document.querySelector('.container');
        const difficultySelect = document.querySelector('.difficulty-select');

        if (container) container.style.display = 'none';
        if (gameContainer) gameContainer.style.display = 'none';
        if (difficultySelect) difficultySelect.style.display = 'flex';
    }


    startTimer() {
        clearInterval(this.timerInterval);
        this.timerInterval = null;

        switch (this.difficulty) {
            case 'easy': this.timer = 30; break;
            case 'medium': this.timer = 45; break;
            case 'hard': this.timer = 60; break;
        }

        this.updateTimer();

        this.timerInterval = setInterval(() => {
            this.timer--;
            this.updateTimer();
            if (this.timer <= 0) {
                clearInterval(this.timerInterval);
                this.timerInterval = null;
                this.handleTimeUp();
            }
        }, 1000);
    }

    updateTimer() {
        const timerElement = document.querySelector('.timer');
        timerElement.textContent = `Thời gian: ${this.formatTime(this.timer)}`;
    }

    updateMoves() {
        document.querySelector('.moves').textContent = `Lượt: ${this.moves}`;
    }

    updateScore() {
        document.querySelector('.current-score').textContent = `Điểm: ${this.score}`;
    }

    formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
    }

    handleTimeUp() {
        this.isPlaying = false;
        clearInterval(this.timerInterval);
        this.timerInterval = null;

        const timeUp = document.querySelector('.time-up');
        timeUp.querySelector('.final-time').textContent = this.formatTime(this.timer);
        timeUp.querySelector('.final-moves').textContent = this.moves;
        timeUp.querySelector('.final-score').textContent = this.score;

        const playAgainButton = timeUp.querySelector('.play-again');
        if (playAgainButton) {
            playAgainButton.onclick = () => this.resetAndReplay(timeUp);
        }

        timeUp.style.display = 'flex';
    }

    saveProgress() {
        const progress = {
            level: this.level,
            score: this.score,
            unlockedTeddies: this.level
        };
        localStorage.setItem(`memoryProgress_${this.playerName}`, JSON.stringify(progress));
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

document.addEventListener('DOMContentLoaded', () => {
    const game = new MemoryGame();

    document.querySelector('.next-level').addEventListener('click', () => {
        game.level++;
        game.resetAndReplay(document.querySelector('.level-complete'));
    });

    document.querySelector('.back-to-select').addEventListener('click', () => {
        game.handleBackToSelect();
    });
});
