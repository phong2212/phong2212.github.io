const teddies = [
    {
        name: "Công Chúa Hồng",
        image: "assets/img/pink-princess.png",
        description: "Một chú gấu hồng xinh xắn với chiếc vương miện dễ thương!",
        rarity: "common"
    },
    {
        name: "Gấu Xanh Dâu",
        image: "assets/img/blue-strawberry.png",
        description: "Một chú gấu xanh ngọt ngào với hoa văn quả dâu!",
        rarity: "common"
    },
    {
        name: "Gấu Dâu Tây",
        image: "assets/img/strawberry.png",
        description: "Một chú gấu trông thật ngon lành với hình dâu tây!",
        rarity: "common"
    },
    {
        name: "Gấu Kẹo Bông",
        image: "assets/img/cotton-candy.png",
        description: "Một chú gấu mềm mại trông như kẹo bông!",
        rarity: "common"
    },
    {
        name: "Gấu Mật Ong",
        image: "assets/img/honey.png",
        description: "Một chú gấu vàng với chiếc bình mật ong!",
        rarity: "common"
    },
    {
        name: "Gấu Cầu Vồng",
        image: "assets/img/rainbow.png",
        description: "Một chú gấu đầy màu sắc và lấp lánh!",
        rarity: "common"
    },
    {
        name: "Gấu Kẹo Dẻo",
        image: "assets/img/gummy.png",
        description: "Một chú gấu trắng mềm mại và dễ thương!",
        rarity: "common"
    },
    {
        name: "Gấu Bánh Cupcake",
        image: "assets/img/cupcake.png",
        description: "Một chú gấu ngọt ngào với trang trí bánh cupcake!",
        rarity: "common"
    },
    {
        name: "Kỳ Lân Vàng",
        image: "assets/img/golden-unicorn.png",
        description: "Một chú kỳ lân vàng hiếm có!",
        rarity: "rare"
    }
];

// Score configuration for each teddy
const TEDDY_SCORES = {
    "Công Chúa Hồng": 100,
    "Gấu Xanh Dâu": 150,
    "Gấu Dâu Tây": 200,
    "Gấu Kẹo Bông": 250,
    "Gấu Mật Ong": 300,
    "Gấu Cầu Vồng": 350,
    "Gấu Kẹo Dẻo": 400,
    "Gấu Bánh Cupcake": 450,
    "Kỳ Lân Vàng": 1000 // Secret bear
};

const SOUNDS = {
    background: new Audio('assets/sound/background.mp3'),
    click: new Audio('assets/sound/click.mp3'),
    rare: new Audio('assets/sound/rare.mp3'),
    common: new Audio('assets/sound/common.mp3')
};

// Set background music to loop
SOUNDS.background.loop = true;

// All possible daily challenges
const ALL_DAILY_CHALLENGES = [
    {
        id: 'score1000',
        description: "Kiếm điểm trong game Xé Túi Mù đạt 1000 điểm",
        reward: 50,
        type: 'teddy',
        condition: (state) => state.currentScore >= 1000
    },
    {
        id: 'score1500',
        description: "Kiếm điểm trong game Xé Túi Mù đạt 1500 điểm",
        reward: 75,
        type: 'teddy',
        condition: (state) => state.currentScore >= 1500
    },
    {
        id: 'score2000',
        description: "Kiếm điểm trong game Xé Túi Mù đạt 2000 điểm",
        reward: 100,
        type: 'teddy',
        condition: (state) => state.currentScore >= 2000
    },
    {
        id: 'score2500',
        description: "Kiếm điểm trong game Xé Túi Mù đạt 2500 điểm",
        reward: 125,
        type: 'teddy',
        condition: (state) => state.currentScore >= 2500
    },
    {
        id: 'score3000',
        description: "Kiếm điểm trong game Xé Túi Mù đạt 3000 điểm",
        reward: 150,
        type: 'teddy',
        condition: (state) => state.currentScore >= 3000
    },
    {
        id: 'twoSameTeddies',
        description: "Mở hộp được 2 gấu bông giống nhau",
        reward: 60,
        type: 'teddy',
        condition: (state) => Object.values(state.teddyCounts).some(count => count >= 2)
    },
    {
        id: 'threeSameTeddies',
        description: "Mở hộp được 3 gấu bông giống nhau",
        reward: 100,
        type: 'teddy',
        condition: (state) => Object.values(state.teddyCounts).some(count => count >= 3)
    },
    {
        id: 'secretTeddy',
        description: "Mở hộp được gấu bông secret",
        reward: 200,
        type: 'teddy',
        condition: (state) => state.teddyCounts['Kỳ Lân Vàng'] > 0
    },
    {
        id: 'threeDifferentTeddies',
        description: "Mở hộp 3 gấu bông khác nhau",
        reward: 80,
        type: 'teddy',
        condition: (state) => Object.keys(state.teddyCounts).length >= 3
    },
    {
        id: 'earn500Coins',
        description: "Kiếm được 500 xu",
        reward: 100,
        type: 'backpack',
        condition: (state) => state.moneyEarned >= 500
    },
    {
        id: 'earn200Coins',
        description: "Kiếm được 200 xu",
        reward: 50,
        type: 'backpack',
        condition: (state) => state.moneyEarned >= 200
    },
    {
        id: 'earn1000Coins',
        description: "Kiếm được 1000 xu",
        reward: 200,
        type: 'backpack',
        condition: (state) => state.moneyEarned >= 1000
    },
    {
        id: 'earn800Coins',
        description: "Kiếm được 800 xu",
        reward: 150,
        type: 'backpack',
        condition: (state) => state.moneyEarned >= 800
    },
    {
        id: 'twoRareZodiacs',
        description: "Mở 2 cung hoàng đạo rare",
        reward: 150,
        type: 'zodiac',
        condition: (state) => state.rareZodiacsCollected >= 2
    },
    {
        id: 'oneEpicZodiac',
        description: "Mở 1 cung hoàng đạo epic",
        reward: 250,
        type: 'zodiac',
        condition: (state) => state.epicZodiacsCollected > 0
    },
    {
        id: 'threeUncommonZodiacs',
        description: "Mở 3 cung hoàng đạo uncommon",
        reward: 120,
        type: 'zodiac',
        condition: (state) => state.uncommonZodiacsCollected >= 3
    },
    {
        id: 'openSpecialPresent',
        description: "Mở hộp quà đặc biệt 1 lần",
        reward: 100,
        type: 'backpack',
        condition: (state) => state.specialPresentsOpened > 0
    }
];

let currentGameState = {
    boxes: [],
    hasPicked: false,
    unlockedTeddies: {},
    teddyCounts: {},
    playerName: '',
    movesLeft: 3,
    currentScore: 0,
    dailyChallenges: {},
    lastPlayDate: null,
    level: 1,
    experience: 0,
    experienceToNextLevel: 100,
    previousScore: null,
    memory: {
        completed: {},
        perfect: false,
        streak: 0,
        timeLeft: 0
    },
    newZodiacs: 0,
    zodiacs: [],
    specialPresentsOpened: 0,
    moneyEarned: 0,
    leveledUp: false,
    gamesCompleted: {
        teddy: false,
        memory: false,
        dash: false
    },
    allBoxesOpened: false,
    rareZodiacsCollected: 0,
    epicZodiacsCollected: 0,
    uncommonZodiacsCollected: 0
};

// Loading screen animation
const loadingScreen = document.querySelector('.loading-screen');
const loadingBear = document.querySelector('.loading-bear');
const progressBar = document.querySelector('.loading-progress-bar');
const progressText = document.querySelector('.loading-progress-text');
const loadingScene = document.querySelector('.loading-scene');
const nameScreen = document.querySelector('.name-screen');
const nameInput = document.querySelector('.name-input');
const keys = document.querySelectorAll('.key');

// Remove readonly from input
nameInput.removeAttribute('readonly');

// Function to animate virtual key
function animateKey(keyChar) {
    keyChar = keyChar.toUpperCase();
    const key = Array.from(keys).find(k => k.textContent === keyChar);
    if (key) {
        key.classList.add('active');
        setTimeout(() => key.classList.remove('active'), 200);
    }
}

// Handle physical keyboard input
nameInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        const key = Array.from(keys).find(k => k.classList.contains('enter'));
        if (key) {
            key.classList.add('active');
            setTimeout(() => key.classList.remove('active'), 200);
        }
        if (nameInput.value.trim()) {
            startGame();
        }
        return;
    }

    if (e.key === 'Backspace') {
        const key = Array.from(keys).find(k => k.classList.contains('backspace'));
        if (key) {
            key.classList.add('active');
            setTimeout(() => key.classList.remove('active'), 200);
        }
        return;
    }

    if (e.key === ' ') {
        const key = Array.from(keys).find(k => k.classList.contains('space'));
        if (key) {
            key.classList.add('active');
            setTimeout(() => key.classList.remove('active'), 200);
        }
        return;
    }

    // Only animate if it's a single letter and convert to uppercase
    if (e.key.length === 1 && e.key.match(/[a-zA-Z]/)) {
        const upperKey = e.key.toUpperCase();
        animateKey(upperKey);
    }
});

// Force uppercase input
nameInput.addEventListener('input', (e) => {
    e.target.value = e.target.value.toUpperCase();
});

// Update handleKeyClick functionđ
function handleKeyClick(key) {
    const keyContent = key.textContent.toUpperCase();
    
    // Add active class for animation
    key.classList.add('active');
    setTimeout(() => key.classList.remove('active'), 200);

    if (key.classList.contains('backspace')) {
        nameInput.value = nameInput.value.slice(0, -1);
    } else if (key.classList.contains('space')) {
        nameInput.value += ' ';
    } else if (key.classList.contains('enter')) {
        if (nameInput.value.trim()) {
            startGame();
        }
    } else {
        nameInput.value += keyContent;
    }

    // Keep focus on input
    nameInput.focus();
}

// Add click event listeners to all keys
keys.forEach(key => {
    key.addEventListener('click', () => handleKeyClick(key));
});

// Focus input when name screen shows
function showNameScreen() {
    nameScreen.classList.add('show');
    setTimeout(() => nameInput.focus(), 500);
}

function updateMovesAndScore() {
    document.querySelector('.moves-left').textContent = `Lượt còn lại: ${currentGameState.movesLeft}`;
    document.querySelector('.current-score').textContent = `Điểm: ${currentGameState.currentScore}`;
}

// Game state management
const gameStates = {
    teddy: {
        element: document.querySelector('.container'),
        isActive: false,
        events: []
    },
    memory: {
        element: null, // Will be set when memory game is initialized
        isActive: false,
        events: []
    },
    dash: {
        element: null, // Will be set when dash game is initialized
        isActive: false,
        events: []
    }
};

function initializeGameStates() {
    // Hide all game containers initially
    Object.values(gameStates).forEach(state => {
        if (state.element) {
            state.element.style.display = 'none';
        }
    });
}

function activateGame(gameType) {
    // Deactivate all games first
    Object.keys(gameStates).forEach(key => {
        if (key !== gameType) {
            deactivateGame(key);
        }
    });

    // Activate the selected game
    const gameState = gameStates[gameType];
    if (gameState) {
        gameState.isActive = true;
        if (gameState.element) {
            gameState.element.style.display = 'block';
        }
    }
}

function deactivateGame(gameType) {
    const gameState = gameStates[gameType];
    if (gameState) {
        gameState.isActive = false;
        if (gameState.element) {
            gameState.element.style.display = 'none';
        }
        // Remove all event listeners
        gameState.events.forEach(event => {
            event.target.removeEventListener(event.type, event.listener);
        });
        gameState.events = [];
    }
}

function startGame() {
    const playerName = nameInput.value.trim().toUpperCase();
    if (playerName) {
        currentGameState.playerName = playerName;
        // Save the player name to localStorage
        localStorage.setItem('lastPlayerName', playerName);
        
        // First show game selection screen and initialize everything
        const gameSelectScreen = document.querySelector('.game-select-screen');
        gameSelectScreen.style.display = 'flex';
        document.querySelector('.name-screen').style.display = 'none';
        
        // Initialize game states and load data
        loadGameState();
        playSound('background', 0.3);
        initializeGameStates();

        // Add click handlers for game cards
        document.querySelectorAll('.game-card').forEach(card => {
            card.addEventListener('click', () => {
                playSound('click');
                const gameType = card.dataset.game;
                if (gameType === 'teddy') {
                    showGameTransition();
                    activateGame('teddy');
                } else if (gameType === 'memory') {
                    if (!memoryMatch) {
                        memoryMatch = new MemoryMatch();
                        gameStates.memory.element = memoryMatch.element;
                    }
                    activateGame('memory');
                    memoryMatch.show();
                } else if (gameType === 'dash') {
                    if (!birthdayDash) {
                        birthdayDash = new BirthdayDash();
                        gameStates.dash.element = birthdayDash.element;
                    }
                    activateGame('dash');
                    birthdayDash.show();
                }
            });
        });

        updateDailyChallenges();
        
        // Show welcome message for new player after everything is initialized
        setTimeout(() => {
            showWelcomeMessage(false);
        }, 100);
    }
}

function startLoadingAnimation() {
    let progress = 0;
    
    // First phase: 0% to 20% in 2s
    const firstPhase = setInterval(() => {
        progress += 1;
        if (progress <= 20) {
            updateProgress(progress);
        } else {
            clearInterval(firstPhase);
            startSecondPhase();
        }
    }, 100);

    function startSecondPhase() {
        // Second phase: 20% to 99% in 5s
        const secondPhase = setInterval(() => {
            progress += 1;
            if (progress <= 99) {
                updateProgress(progress);
            } else {
                clearInterval(secondPhase);
                startFinalPhase();
            }
        }, 50);
    }

    function startFinalPhase() {
        // Final phase: wait 5s at 99%
        setTimeout(() => {
            progress = 100;
            updateProgress(progress);
            setTimeout(() => {
                loadingScreen.classList.add('hide');
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                    showNameScreen(); // Show name input screen after loading
                }, 500);
            }, 500);
        }, 5000);
    }

    function updateProgress(value) {
        progressBar.style.width = `${value}%`;
        progressText.textContent = `${value}%`;
        
        // Calculate bear position based on scene width
        const sceneWidth = loadingScene.offsetWidth;
        const bearWidth = loadingBear.offsetWidth;
        const maxLeft = sceneWidth - bearWidth;
        const bearPosition = (value / 100) * maxLeft;
        loadingBear.style.left = `${bearPosition}px`;
    }
}

// Hide the main container initially
document.querySelector('.container').style.display = 'none';

// Modify window load event listener
window.addEventListener('load', () => {
    const lastPlayerName = localStorage.getItem('lastPlayerName');
    if (lastPlayerName) {
        // Skip loading and name screens if there's a saved name
        currentGameState.playerName = lastPlayerName;
        loadingScreen.style.display = 'none';
        nameScreen.style.display = 'none';
        
        // First show game selection screen and initialize everything
        const gameSelectScreen = document.querySelector('.game-select-screen');
        gameSelectScreen.style.display = 'flex';
        
        // Initialize game states and load data
        loadGameState();
        playSound('background', 0.3);
        initializeGameStates();
        
        // Add click handlers for game cards
        document.querySelectorAll('.game-card').forEach(card => {
            card.addEventListener('click', () => {
                playSound('click');
                const gameType = card.dataset.game;
                if (gameType === 'teddy') {
                    showGameTransition();
                    activateGame('teddy');
                } else if (gameType === 'memory') {
                    if (!memoryMatch) {
                        memoryMatch = new MemoryMatch();
                        gameStates.memory.element = memoryMatch.element;
                    }
                    activateGame('memory');
                    memoryMatch.show();
                } else if (gameType === 'dash') {
                    if (!birthdayDash) {
                        birthdayDash = new BirthdayDash();
                        gameStates.dash.element = birthdayDash.element;
                    }
                    activateGame('dash');
                    birthdayDash.show();
                }
            });
        });

        updateDailyChallenges();
        
        // Show welcome back message after everything is initialized
        setTimeout(() => {
            showWelcomeMessage(true);
        }, 100);
    } else {
        // Show loading screen and name input for new players
        startLoadingAnimation();
    }
});

function createBoxes() {
    const boxesContainer = document.querySelector('.boxes-container');
    const restartButton = document.getElementById('restartButton');
    
    boxesContainer.innerHTML = '';
    boxesContainer.innerHTML = `
        <div class="play-again-overlay">
            <button>
                <i class="fas fa-redo"></i> Chơi Lại
            </button>
        </div>
    `;
    boxesContainer.classList.remove('has-picked');
    restartButton.classList.remove('show');
    
    const shuffledTeddies = [...teddies].sort(() => Math.random() - 0.5);
    currentGameState.boxes = shuffledTeddies;

    shuffledTeddies.forEach((teddy, index) => {
        const box = document.createElement('div');
        box.className = 'box';
        box.dataset.index = index;
        box.addEventListener('click', () => unboxTeddy(index));
        boxesContainer.appendChild(box);
    });

    document.querySelector('.play-again-overlay button').addEventListener('click', resetGame);
}

function addUnlockedTeddy(teddy) {
    if (!currentGameState.teddyCounts[teddy.name]) {
        currentGameState.teddyCounts[teddy.name] = 1;
    } else {
        currentGameState.teddyCounts[teddy.name]++;
    }

    // Only add to unlockedTeddies if it's a secret teddy
    if (teddy.rarity === 'rare' && !currentGameState.unlockedTeddies[teddy.name]) {
        currentGameState.unlockedTeddies[teddy.name] = teddy;
    }

    updateUnlockedDisplay();
    saveGameState();
}

function updateUnlockedDisplay() {
    const unlockedContainer = document.querySelector('.unlocked-container');
    unlockedContainer.innerHTML = '';

    Object.entries(currentGameState.teddyCounts).forEach(([name, count]) => {
        const teddy = teddies.find(t => t.name === name);
        if (teddy) {
        const unlockedItem = document.createElement('div');
            unlockedItem.className = `unlocked-item ${teddy.rarity === 'rare' ? 'shiny' : ''}`;
            
            const teddyInfo = document.createElement('div');
            teddyInfo.className = 'teddy-info';
            
            const nameSpan = document.createElement('span');
            nameSpan.className = 'teddy-name';
            nameSpan.textContent = name;
            
            const scoreSpan = document.createElement('span');
            scoreSpan.className = 'teddy-score';
            scoreSpan.textContent = `+${TEDDY_SCORES[name]} điểm`;
            
            teddyInfo.appendChild(nameSpan);
            teddyInfo.appendChild(scoreSpan);
            
            unlockedItem.appendChild(teddyInfo);
            
            if (count > 1) {
                const countSpan = document.createElement('span');
                countSpan.className = 'teddy-count show';
                countSpan.textContent = `x${count}`;
                unlockedItem.appendChild(countSpan);
            }
            
        unlockedContainer.appendChild(unlockedItem);
        }
    });
}

function playSound(type, volume = 1) {
    if (SOUNDS[type]) {
        SOUNDS[type].volume = volume;
        SOUNDS[type].play().catch(e => console.log("Lỗi phát âm thanh:", e));
    }
}

function updateDailyChallenges() {
    const today = new Date().toDateString();
    if (currentGameState.lastPlayDate !== today) {
        // Reset challenges for new day
        currentGameState.dailyChallenges = {};
        
        // Randomly select 3 unique challenges
        const availableChallenges = [...ALL_DAILY_CHALLENGES];
        for (let i = 0; i < 3; i++) {
            if (availableChallenges.length === 0) break;
            
            const randomIndex = Math.floor(Math.random() * availableChallenges.length);
            const challenge = availableChallenges[randomIndex];
            
            currentGameState.dailyChallenges[challenge.id] = {
                ...challenge,
                completed: false
            };
            
            availableChallenges.splice(randomIndex, 1);
        }
        
        currentGameState.lastPlayDate = today;
        saveGameState();
    }
}

// Make showDailyChallenges function globally accessible
window.showDailyChallenges = function() {
    const existingChallenges = document.querySelector('.daily-challenges');
    if (existingChallenges) {
        existingChallenges.remove();
    }

    const challengesContainer = document.createElement('div');
    challengesContainer.className = 'daily-challenges';
    challengesContainer.innerHTML = `
        <div class="challenges-header">
            <h2><i class="fas fa-star"></i> Thử Thách Hằng Ngày</h2>
            <button class="close-challenges"><i class="fas fa-times"></i></button>
        </div>
        <div class="challenges-list">
            ${Object.entries(currentGameState.dailyChallenges).map(([key, challenge]) => `
                <div class="challenge-item ${challenge.completed ? 'completed' : ''}">
                    <i class="fas ${challenge.completed ? 'fa-check-circle' : 'fa-circle'}"></i>
                    <span>${challenge.description}</span>
                    <span class="reward">+${challenge.reward} exp</span>
                </div>
            `).join('')}
        </div>
    `;
    
    document.body.appendChild(challengesContainer);
    challengesContainer.classList.add('show');
    playSound('click', 0.5);

    // Add close button functionality
    const closeButton = challengesContainer.querySelector('.close-challenges');
    closeButton.addEventListener('click', () => {
        playSound('click');
        challengesContainer.remove();
    });
};

function unboxTeddy(index) {
    if (currentGameState.hasPicked || currentGameState.movesLeft <= 0) return;

    const box = document.querySelector(`.box[data-index="${index}"]`);
    const unboxedTeddy = document.getElementById('unboxedTeddy');
    const teddyImage = document.getElementById('teddyImage');
    const teddyName = document.getElementById('teddyName');
    const teddyDescription = document.getElementById('teddyDescription');
    const boxesContainer = document.querySelector('.boxes-container');
    const restartButton = document.getElementById('restartButton');
    const teddyContent = unboxedTeddy.querySelector('.teddy-content');

    // Remove any existing close button
    const existingCloseButton = teddyContent.querySelector('.game-over-button.close');
    if (existingCloseButton) {
        existingCloseButton.remove();
    }

    currentGameState.hasPicked = true;
    currentGameState.movesLeft--;
    boxesContainer.classList.add('has-picked');
    box.classList.add('picked');

    const teddy = currentGameState.boxes[index];
    
    if (teddy.rarity === 'rare') {
        box.classList.add('secret');
        playSound('rare', 0.8);
        teddyName.classList.add('secret');
        teddyDescription.classList.add('secret');
        // Add money for rare teddies
        if (window.zodiacSystem) {
            window.zodiacSystem.addMoney(50);
            currentGameState.moneyEarned += 50;
        }
    } else {
        playSound('common', 0.6);
        teddyName.classList.remove('secret');
        teddyDescription.classList.remove('secret');
        
        // Add money for common teddies
        if (window.zodiacSystem) {
            window.zodiacSystem.addMoney(10);
            currentGameState.moneyEarned += 10;
        }
    }

    playSound('click', 0.5);

    setTimeout(() => {
        addUnlockedTeddy(teddy);
        teddyImage.src = teddy.image;
        teddyName.textContent = teddy.name;
        teddyDescription.textContent = teddy.description;
        unboxedTeddy.style.display = 'block';

        // Update game state for challenges
        currentGameState.gamesCompleted.teddy = true;
        
        // Check if all boxes are opened
        const allBoxesOpened = document.querySelectorAll('.box:not(.opened)').length === 0;
        if (allBoxesOpened) {
            currentGameState.allBoxesOpened = true;
        }
        
        // Check challenges
        checkChallenges();

        // Add score
        const score = TEDDY_SCORES[teddy.name];
        currentGameState.currentScore += score;
        updateMovesAndScore();

        if (teddy.rarity === 'rare') {
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 }
            });
        }

        // Show restart button for first two moves, close button for last move
        if (currentGameState.movesLeft > 0) {
            restartButton.style.display = 'block';
            restartButton.textContent = 'Chọn Lại';
            restartButton.classList.add('show');
            // Remove any existing close button
            const existingCloseButton = teddyContent.querySelector('.game-over-button.close');
            if (existingCloseButton) {
                existingCloseButton.remove();
            }
        } else {
            restartButton.style.display = 'none';
            restartButton.classList.remove('show');
            const closeButton = document.createElement('button');
            closeButton.className = 'game-over-button close';
            closeButton.textContent = 'Đóng';
            closeButton.onclick = () => {
                unboxedTeddy.style.display = 'none';
                setTimeout(showGameOver, 500);
            };
            teddyContent.appendChild(closeButton);
        }

        // Save game state after each move
        saveGameState();
    }, 500);
}

function showChallengeComplete(challengeKey) {
    const challenge = currentGameState.dailyChallenges[challengeKey];
    const completionPopup = document.createElement('div');
    completionPopup.className = 'challenge-complete';
    completionPopup.innerHTML = `
        <div class="challenge-content">
            <i class="fas fa-star"></i>
            <h3>Hoàn Thành Thử Thách!</h3>
            <p>${challenge.description}</p>
            <div class="challenge-rewards">
                <div class="reward-item">
                    <i class="fas fa-star"></i>
                    <span>+${challenge.reward} exp</span>
                </div>
            </div>
            <button class="close-challenge">Đóng</button>
        </div>
    `;
    
    document.body.appendChild(completionPopup);
    playSound('rare', 0.5);
    
    // Add experience equal to the challenge reward
    addExperience(challenge.reward);
    
    // Add close button functionality
    const closeButton = completionPopup.querySelector('.close-challenge');
    closeButton.addEventListener('click', () => {
        completionPopup.remove();
    });
}

function showGameOver() {
    const gameOver = document.createElement('div');
    gameOver.className = 'game-over';

    // Store previous score before updating
    const previousScore = currentGameState.previousScore;
    currentGameState.previousScore = currentGameState.currentScore;

    // Calculate coins based on score
    const coinsGained = Math.floor(currentGameState.currentScore / 400) * 5;

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

    // Prepare score change message
    let scoreChangeMsg = '';
    if (previousScore !== null) {
        const scoreDiff = currentGameState.currentScore - previousScore;
        if (scoreDiff > 0) {
            scoreChangeMsg = `<p class="score-change positive">+${scoreDiff} điểm so với lần trước!</p>`;
        } else if (scoreDiff < 0) {
            scoreChangeMsg = `<p class="score-change negative">${scoreDiff} điểm so với lần trước</p>`;
        } else {
            scoreChangeMsg = `<p class="score-change">Điểm số không đổi</p>`;
        }
    }

    gameOver.innerHTML = `
        <div class="game-over-content">
            <h2>Trò Chơi Kết Thúc!</h2>
            <p>Tên người chơi: ${currentGameState.playerName}</p>
            <p>Điểm của bạn: ${currentGameState.currentScore}</p>
            ${scoreChangeMsg}
            <p class="exp-gained">+${coinsGained} xu</p>
            ${zodiacReward ? `<p class="exp-gained">+${zodiacReward}</p>` : ''}
            <div class="game-over-buttons">
                <button class="game-over-button play-again">Chơi Lại</button>
                <button class="game-over-button close">Đóng</button>
            </div>
        </div>
    `;
    document.body.appendChild(gameOver);

    const playAgainButton = gameOver.querySelector('.play-again');
    const closeButton = gameOver.querySelector('.close');

    playAgainButton.addEventListener('click', () => {
        resetGame();
        gameOver.remove();
        hidePlayAgainOverlay();
    });

    closeButton.addEventListener('click', () => {
        gameOver.remove();
        showPlayAgainOverlay();
    });

    saveGameState();
}

function showPlayAgainOverlay() {
    const overlay = document.querySelector('.play-again-overlay');
    overlay.classList.add('show');
}

function hidePlayAgainOverlay() {
    const overlay = document.querySelector('.play-again-overlay');
    overlay.classList.remove('show');
}

function resetGame() {
    // Reset game state but keep player data
    const playerData = {
        level: currentGameState.level,
        experience: currentGameState.experience,
        experienceToNextLevel: currentGameState.experienceToNextLevel,
        dailyChallenges: currentGameState.dailyChallenges,
        lastPlayDate: currentGameState.lastPlayDate
    };

    // Reset game state
    currentGameState = {
        ...currentGameState,
        boxes: [],
        hasPicked: false,
        movesLeft: 3,
        currentScore: 0,
        unlockedTeddies: {},  // Reset unlocked teddies
        teddyCounts: {}       // Reset teddy counts
    };

    // Restore player data
    Object.assign(currentGameState, playerData);

    // Hide unboxed teddy and remove any close button
    const unboxedTeddy = document.getElementById('unboxedTeddy');
    const teddyContent = unboxedTeddy.querySelector('.teddy-content');
    const existingCloseButton = teddyContent.querySelector('.game-over-button.close');
    if (existingCloseButton) {
        existingCloseButton.remove();
    }
    unboxedTeddy.style.display = 'none';

    // Clear unlocked section
    const unlockedContainer = document.querySelector('.unlocked-container');
    if (unlockedContainer) {
        unlockedContainer.innerHTML = '';
    }

    createBoxes();
    updateMovesAndScore();
    hidePlayAgainOverlay();
    saveGameState();
}

document.addEventListener('click', (e) => {
    const unboxedTeddy = document.getElementById('unboxedTeddy');
    if (e.target === unboxedTeddy) {
        // Prevent closing when clicking outside
        e.stopPropagation();
    }
});

document.getElementById('restartButton').addEventListener('click', () => {
    const unboxedTeddy = document.getElementById('unboxedTeddy');
    unboxedTeddy.style.display = 'none';
    currentGameState.hasPicked = false;
    createBoxes();
    playSound('click');
});

function showGameTransition(isGoingBack = false) {
    const transitionScreen = document.querySelector('.game-transition');
    const transitionText = transitionScreen.querySelector('.game-transition-text');
    const container = document.querySelector('.container');
    const gameSelectScreen = document.querySelector('.game-select-screen');

    transitionText.textContent = isGoingBack ? 'Đang rời game...' : 'Đang vào game...';
    transitionScreen.style.display = 'flex';
    transitionScreen.style.zIndex = '9999';
    
    if (isGoingBack) {
        container.style.display = 'none';
        if (SOUNDS.background) {
            SOUNDS.background.pause();
        }
    } else {
        gameSelectScreen.style.display = 'none';
    }

    setTimeout(() => {
        transitionScreen.style.display = 'none';
        if (isGoingBack) {
            gameSelectScreen.style.display = 'flex';
            // Reset any active game states
            Object.keys(gameStates).forEach(key => {
                if (gameStates[key].isActive) {
                    deactivateGame(key);
                }
            });
        } else {
            container.style.display = 'flex';
            resetGame();
        }
    }, 2000);
}

// Add after the SOUNDS constant
const dailyChallengesButton = document.querySelector('.daily-challenges-button');
const backToSelectButton = document.querySelector('.back-to-select');

// Add click handler for daily challenges button
dailyChallengesButton.addEventListener('click', () => {
    playSound('click');
    showDailyChallenges();
});

// Add styles for the close button
const style = document.createElement('style');
style.textContent = `
    .challenges-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .close-challenges {
        background: none;
        border: none;
        color: #ff69b4;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 5px;
        transition: transform 0.3s ease;
    }
    
    .close-challenges:hover {
        transform: rotate(90deg);
    }
`;
document.head.appendChild(style);

createBoxes(); 

// Add after the currentGameState initialization
function updateLevelDisplay() {
    const levelDisplay = document.querySelector('.level-display span');
    const experienceBar = document.querySelector('.experience-bar');
    const experienceProgress = document.querySelector('.experience-progress');
    
    levelDisplay.textContent = `Level: ${currentGameState.level}`;
    const progress = Math.min((currentGameState.experience / currentGameState.experienceToNextLevel) * 100, 100);
    experienceProgress.style.width = `${progress}%`;
    experienceBar.setAttribute('data-progress', `${Math.round(progress)}%`);
}

function addExperience(amount) {
    currentGameState.experience += amount;
    
    // Check for level up
    if (currentGameState.experience >= currentGameState.experienceToNextLevel) {
        // Calculate how many levels to gain
        let levelsGained = 0;
        let remainingExp = currentGameState.experience;
        let currentExpToNext = currentGameState.experienceToNextLevel;
        
        while (remainingExp >= currentExpToNext) {
            levelsGained++;
            remainingExp -= currentExpToNext;
            currentExpToNext = Math.floor(currentExpToNext * 1.5);
        }
        
        // Store the current level and experience
        const originalLevel = currentGameState.level;
        const originalExp = currentGameState.experience;
        const originalExpToNext = currentGameState.experienceToNextLevel;
        
        // Update to final values
        currentGameState.level += levelsGained;
        currentGameState.experience = remainingExp;
        currentGameState.experienceToNextLevel = currentExpToNext;
        currentGameState.leveledUp = true;
        
        // Create array of levels to show
        currentGameState.pendingLevelUps = [];
        for (let i = 1; i <= levelsGained; i++) {
            currentGameState.pendingLevelUps.push(originalLevel + i);
        }
        
        // Only show level up effect in game select screen
        if (document.querySelector('.game-select-screen')) {
            showLevelUp();
        }
    }
    
    updateLevelDisplay();
    saveGameState();
}

function createConfetti() {
    const effect = document.createElement('div');
    effect.className = 'level-up-effect';
    
    for (let i = 0; i < 100; i++) {
        const confetti = document.createElement('div');
        confetti.className = 'confetti';
        confetti.style.left = `${Math.random() * 100}%`;
        confetti.style.top = `${Math.random() * 100}%`;
        confetti.style.animationDelay = `${Math.random() * 2}s`;
        confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 100%, 50%)`;
        effect.appendChild(confetti);
    }
    
    document.body.appendChild(effect);
    setTimeout(() => effect.remove(), 3000);
}

function showLevelUp() {
    // Only show level up in game select screen
    const gameSelectScreen = document.querySelector('.game-select-screen');
    if (!gameSelectScreen) return;
    
    // Create confetti container first
    const confettiContainer = document.createElement('div');
    confettiContainer.className = 'level-up-confetti';
    gameSelectScreen.appendChild(confettiContainer);
    
    // Create confetti elements
    for (let i = 0; i < 50; i++) {
        const confetti = document.createElement('div');
        confetti.className = 'confetti';
        confetti.style.left = `${Math.random() * 100}%`;
        confetti.style.top = `${Math.random() * 100}%`;
        confetti.style.animationDelay = `${Math.random() * 2}s`;
        confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 100%, 50%)`;
        confettiContainer.appendChild(confetti);
    }
    
    const levelUpPopup = document.createElement('div');
    levelUpPopup.className = 'challenge-complete level-up-popup';
    levelUpPopup.innerHTML = `
        <div class="challenge-content">
            <div class="level-up-icon">
                <i class="fas fa-star"></i>
            </div>
            <h3>Level Up!</h3>
            <p>Chúc mừng bạn đã lên cấp ${currentGameState.pendingLevelUps[0]}!</p>
            <div class="challenge-rewards">
                <div class="reward-item" style="animation-delay: 0.2s">
                    <i class="fas fa-gift"></i>
                    <span>Hộp quà đặc biệt x1</span>
                </div>
                <div class="reward-item" style="animation-delay: 0.4s">
                    <i class="fas fa-coins"></i>
                    <span>+100 xu</span>
                </div>
                <div class="reward-item" style="animation-delay: 0.6s">
                    <i class="fas fa-star"></i>
                    <span>+50 exp</span>
                </div>
            </div>
            <button class="close-challenge">Đóng</button>
        </div>
    `;
    
    gameSelectScreen.appendChild(levelUpPopup);
    playSound('levelup', 0.5);

    // Add close button functionality
    const closeButton = levelUpPopup.querySelector('.close-challenge');
    closeButton.addEventListener('click', () => {
        // Only update rewards when user closes the popup
        if (window.zodiacSystem) {
            window.zodiacSystem.addMoney(100);
            window.zodiacSystem.addSpecialPresent();
            currentGameState.moneyEarned += 100;
        }
        addExperience(50);
        
        levelUpPopup.remove();
        confettiContainer.remove();
        
        // Check if there are more level ups to show
        if (currentGameState.pendingLevelUps && currentGameState.pendingLevelUps.length > 0) {
            currentGameState.pendingLevelUps.shift(); // Remove the current level
            if (currentGameState.pendingLevelUps.length > 0) {
                // Show next level up
                setTimeout(() => {
                    showLevelUp();
                }, 500); // Small delay between level ups
            }
        }
    });
}

function saveGameState() {
    // Save game state with player name
    const gameState = {
        level: currentGameState.level,
        experience: currentGameState.experience,
        experienceToNextLevel: currentGameState.experienceToNextLevel,
        currentScore: currentGameState.currentScore,
        previousScore: currentGameState.previousScore,
        dailyChallenges: currentGameState.dailyChallenges,
        lastPlayDate: currentGameState.lastPlayDate,
        unlockedTeddies: currentGameState.unlockedTeddies,
        teddyCounts: currentGameState.teddyCounts
    };
    localStorage.setItem(`gameState_${currentGameState.playerName}`, JSON.stringify(gameState));

    // Also save level separately for quick access
    localStorage.setItem('playerLevel', currentGameState.level);
    localStorage.setItem('playerExperience', currentGameState.experience);
    localStorage.setItem('playerExperienceToNextLevel', currentGameState.experienceToNextLevel);
}

function loadGameState() {
    // First try to load from player-specific state
    const savedState = localStorage.getItem(`gameState_${currentGameState.playerName}`);
    if (savedState) {
        const parsedState = JSON.parse(savedState);
        
        // Restore daily challenges with their condition functions
        if (parsedState.dailyChallenges) {
            const restoredChallenges = {};
            Object.entries(parsedState.dailyChallenges).forEach(([key, challenge]) => {
                const originalChallenge = ALL_DAILY_CHALLENGES.find(c => c.id === key);
                if (originalChallenge) {
                    restoredChallenges[key] = {
                        ...challenge,
                        condition: originalChallenge.condition
                    };
                }
            });
            parsedState.dailyChallenges = restoredChallenges;
        }

        currentGameState = {
            ...currentGameState,
            ...parsedState,
            hasPicked: false // Reset hasPicked on load
        };
    } else {
        // If no player-specific state, load from general level data
        const savedLevel = localStorage.getItem('playerLevel');
        const savedExp = localStorage.getItem('playerExperience');
        const savedExpToNext = localStorage.getItem('playerExperienceToNextLevel');
        
        if (savedLevel) {
            currentGameState.level = parseInt(savedLevel);
            currentGameState.experience = parseInt(savedExp) || 0;
            currentGameState.experienceToNextLevel = parseInt(savedExpToNext) || 100;
        }
    }

    // Check for temporary exp and coins from memory game
    const tempExp = parseInt(localStorage.getItem('tempExp') || '0');
    const tempXu = parseInt(localStorage.getItem('tempXu') || '0');
    
    console.log('Script - Current state before adding rewards:');
    console.log('Current exp:', currentGameState.experience);
    console.log('Current coins:', window.zodiacSystem ? window.zodiacSystem.backpack.money : 'N/A');
    console.log('Found tempExp:', tempExp);
    console.log('Found tempXu:', tempXu);
    
    if (tempExp > 0) {
        console.log('Script - Adding exp:', tempExp);
        addExperience(tempExp);
        console.log('Script - New exp after adding:', currentGameState.experience);
        localStorage.removeItem('tempExp');
        console.log('Script - tempExp after removal:', localStorage.getItem('tempExp'));
    }
    
    if (tempXu > 0) {
        if (window.zodiacSystem) {
            console.log('Script - Adding coins:', tempXu);
            window.zodiacSystem.addMoney(tempXu);
            console.log('Script - New coins after adding:', window.zodiacSystem.backpack.money);
        }
        localStorage.removeItem('tempXu');
        console.log('Script - tempXu after removal:', localStorage.getItem('tempXu'));
    }

    // Update UI based on loaded state
    updateMovesAndScore();
    updateUnlockedDisplay();
    updateLevelDisplay();

    // If there was an unboxed teddy, show it with correct buttons
    if (currentGameState.movesLeft < 3) {
        const unboxedTeddy = document.getElementById('unboxedTeddy');
        if (unboxedTeddy) {
            const teddyContent = unboxedTeddy.querySelector('.teddy-content');
            const restartButton = document.getElementById('restartButton');

            // Remove any existing close button
            const existingCloseButton = teddyContent.querySelector('.game-over-button.close');
            if (existingCloseButton) {
                existingCloseButton.remove();
            }

            if (currentGameState.movesLeft > 0) {
                if (restartButton) {
                    restartButton.style.display = 'block';
                    restartButton.textContent = 'Chọn Lại';
                    restartButton.classList.add('show');
                }
            } else {
                if (restartButton) {
                    restartButton.style.display = 'none';
                    restartButton.classList.remove('show');
                }
                const closeButton = document.createElement('button');
                closeButton.className = 'game-over-button close';
                closeButton.textContent = 'Đóng';
                closeButton.onclick = () => {
                    unboxedTeddy.style.display = 'none';
                    setTimeout(showGameOver, 500);
                };
                teddyContent.appendChild(closeButton);
            }
        }
    }
}

// Initialize level display
updateLevelDisplay();

// Add reset data button functionality
document.querySelector('.reset-data-button').addEventListener('click', () => {
    if (confirm('Bạn có chắc chắn muốn xóa tất cả dữ liệu?')) {
        localStorage.clear();
        location.reload();
    }
});

// Initialize games
let memoryMatch = null;
let birthdayDash = null;

// Add welcome message function
function showWelcomeMessage(isReturningPlayer) {
    const welcomeMessage = document.createElement('div');
    welcomeMessage.className = 'welcome-message';
    welcomeMessage.innerHTML = `
        <div class="welcome-content">
            <i class="fas ${isReturningPlayer ? 'fa-heart' : 'fa-star'}"></i>
            <h2>${isReturningPlayer ? 'Chào mừng trở lại!' : 'Chào mừng bạn đến với Birthday Game Collection!'}</h2>
            <p>${isReturningPlayer ? `Xin chào ${currentGameState.playerName}! Chúc bạn chơi game vui vẻ!` : 'Hãy bắt đầu cuộc phiêu lưu của bạn!'}</p>
            <button class="close-welcome">Bắt đầu</button>
        </div>
    `;
    
    document.querySelector('.game-select-screen').appendChild(welcomeMessage);
    playSound('click', 0.5);

    // Add close button functionality
    const closeButton = welcomeMessage.querySelector('.close-welcome');
    closeButton.addEventListener('click', () => {
        welcomeMessage.remove();
        if (!isReturningPlayer) {
            // Only show welcome gift after closing welcome message
            showWelcomeGift();
        }
    });
}

function createBalloons() {
    const colors = ['#ff69b4', '#ff1493', '#ffd1dc', '#ffb6c1', '#ffc0cb'];
    for (let i = 0; i < 20; i++) {
        const balloon = document.createElement('div');
        balloon.className = 'balloon';
        balloon.style.left = Math.random() * 100 + 'vw';
        balloon.style.animationDelay = Math.random() * 5 + 's';
        balloon.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        document.body.appendChild(balloon);
        
        // Remove balloon after animation
        setTimeout(() => {
            balloon.remove();
        }, 8000);
    }
}

function createFireworks() {
    const colors = ['#ff69b4', '#ff1493', '#ffd1dc', '#ffb6c1', '#ffc0cb'];
    for (let i = 0; i < 50; i++) {
        setTimeout(() => {
            const firework = document.createElement('div');
            firework.className = 'firework';
            firework.style.left = Math.random() * 100 + 'vw';
            firework.style.top = Math.random() * 100 + 'vh';
            firework.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            document.body.appendChild(firework);
            
            // Remove firework after animation
            setTimeout(() => {
                firework.remove();
            }, 1000);
        }, i * 100);
    }
}

function showWelcomeGift() {
    const giftPopup = document.createElement('div');
    giftPopup.className = 'welcome-gift';
    giftPopup.innerHTML = `
        <div class="gift-content">
            <div class="gift-box">
                <img src="assets/img/present.png" alt="Hộp quà chào mừng" class="gift-image">
            </div>
            <p>Nhấn vào hộp quà để nhận quà chào mừng!</p>
        </div>
    `;
    
    document.querySelector('.game-select-screen').appendChild(giftPopup);

    const giftBox = giftPopup.querySelector('.gift-box');
    giftBox.addEventListener('click', () => {
        // Show reward popup
        const rewardPopup = document.createElement('div');
        rewardPopup.className = 'challenge-complete';
        rewardPopup.innerHTML = `
            <div class="challenge-content">
                <i class="fas fa-gift"></i>
                <h3>Chúc Mừng!</h3>
                <p>Bạn đã nhận được quà chào mừng!</p>
                <div class="challenge-rewards">
                    <div class="reward-item">
                        <i class="fas fa-gift"></i>
                        <span>Hộp quà đặc biệt x1</span>
                    </div>
                    <div class="reward-item">
                        <i class="fas fa-coins"></i>
                        <span>+100 xu</span>
                    </div>
                    <div class="reward-item">
                        <i class="fas fa-star"></i>
                        <span>+10 exp</span>
                    </div>
                </div>
                <button class="close-challenge">Đóng</button>
            </div>
        `;
        
        document.body.appendChild(rewardPopup);
        playSound('rare', 0.8);
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 }
        });

        // Remove gift popup
        giftPopup.remove();

        // Handle close button
        const closeButton = rewardPopup.querySelector('.close-challenge');
        closeButton.addEventListener('click', () => {
            // Only add rewards after user clicks close
            if (window.zodiacSystem) {
                window.zodiacSystem.addMoney(100);
                window.zodiacSystem.addSpecialPresent();
                currentGameState.moneyEarned += 100;
            }
            addExperience(10);
            
            rewardPopup.remove();
            
            // Check if player name is MAI and show birthday gift
            if (currentGameState.playerName === 'MAI') {
                setTimeout(() => {
                    // Create birthday effects
                    createBalloons();
                    createFireworks();
                    
                    // Play birthday sound
                    const birthdaySound = new Audio('assets/sound/hb.mp3');
                    birthdaySound.volume = 0.5;
                    birthdaySound.play();
                    
                    const birthdayPopup = document.createElement('div');
                    birthdayPopup.className = 'challenge-complete';
                    birthdayPopup.innerHTML = `
                        <div class="challenge-content">
                            <i class="fas fa-birthday-cake"></i>
                            <h3>Chúc Mừng Sinh Nhật!</h3>
                            <p>Chúc Mai có một ngày được một giấc ngủ ngon!</p>
                            <div class="challenge-rewards">
                                <div class="reward-item">
                                    <i class="fas fa-gift"></i>
                                    <span>Hộp quà đặc biệt x3</span>
                                </div>
                                <div class="reward-item">
                                    <i class="fas fa-coins"></i>
                                    <span>+500 xu</span>
                                </div>
                                <div class="reward-item">
                                    <i class="fas fa-star"></i>
                                    <span>+300 exp</span>
                                </div>
                            </div>
                            <button class="close-challenge">Cảm ơn</button>
                        </div>
                    `;
                    
                    document.body.appendChild(birthdayPopup);
                    playSound('rare', 1.0);
                    confetti({
                        particleCount: 200,
                        spread: 90,
                        origin: { y: 0.6 },
                        colors: ['#ff69b4', '#ff1493', '#ffd1dc']
                    });

                    // Handle close button
                    const birthdayCloseButton = birthdayPopup.querySelector('.close-challenge');
                    birthdayCloseButton.addEventListener('click', () => {
                        // Only add birthday rewards after user clicks close
                        if (window.zodiacSystem) {
                            window.zodiacSystem.addMoney(500);
                            // Add 3 special presents
                            for (let i = 0; i < 3; i++) {
                                window.zodiacSystem.addSpecialPresent();
                            }
                            currentGameState.moneyEarned += 500;
                        }
                        addExperience(300);
                        
                        birthdayPopup.remove();
                    });
                }, 500);
            }
        });
    });
}

function checkChallenges() {
    Object.entries(currentGameState.dailyChallenges).forEach(([key, challenge]) => {
        if (!challenge.completed && challenge.condition(currentGameState)) {
            challenge.completed = true;
            currentGameState.currentScore += challenge.reward;
            
            // Show completion notification
            const completionPopup = document.createElement('div');
            completionPopup.className = 'challenge-complete';
            completionPopup.style.zIndex = '1000';
            completionPopup.innerHTML = `
                <div class="challenge-content">
                    <i class="fas fa-star"></i>
                    <h3>Hoàn Thành Thử Thách!</h3>
                    <p>${challenge.description}</p>
                    <div class="challenge-rewards">
                        <div class="reward-item">
                            <i class="fas fa-star"></i>
                            <span>+${challenge.reward} exp</span>
                        </div>
                    </div>
                    <button class="close-challenge">Đóng</button>
                </div>
            `;
            
            document.body.appendChild(completionPopup);
            playSound('rare', 0.5);
            
            // Add experience equal to the challenge reward
            addExperience(challenge.reward);
            
            // Add confetti effect
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 },
                zIndex: 999
            });
            
            // Add close button functionality
            const closeButton = completionPopup.querySelector('.close-challenge');
            closeButton.addEventListener('click', () => {
                completionPopup.remove();
            });
        }
    });
}