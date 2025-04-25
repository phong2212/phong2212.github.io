// Zodiac and Backpack System
class ZodiacSystem {
    constructor() {
        this.zodiacSigns = [
            { id: 1, name: 'Bạch Dương', rate: 0.5, rarity: 'common' },
            { id: 2, name: 'Kim Ngưu', rate: 0.05, rarity: 'epic' },
            { id: 3, name: 'Song Tử', rate: 0.5, rarity: 'common' },
            { id: 4, name: 'Cự Giải', rate: 0.5, rarity: 'common' },
            { id: 5, name: 'Sư Tử', rate: 0.1, rarity: 'rare' },
            { id: 6, name: 'Xử Nữ', rate: 0.5, rarity: 'common' },
            { id: 7, name: 'Thiên Bình', rate: 0.5, rarity: 'common' },
            { id: 8, name: 'Bò Cạp', rate: 0.1, rarity: 'rare' },
            { id: 9, name: 'Nhân Mã', rate: 0.5, rarity: 'common' },
            { id: 10, name: 'Ma Kết', rate: 0.1, rarity: 'rare' },
            { id: 11, name: 'Bảo Bình', rate: 0.1, rarity: 'rare' },
            { id: 12, name: 'Song Ngư', rate: 0.1, rarity: 'rare' }
        ];

        this.backpack = {
            money: 0,
            items: new Array(6).fill(null)
        };

        this.collectedZodiacs = new Array(12).fill(0);

        this.initializeUI();
        this.loadData();
    }

    initializeUI() {
        // Mission button
        const missionButton = document.querySelector('.mission-button');
        missionButton.addEventListener('click', () => {
            if (typeof window.showDailyChallenges === 'function') {
                window.showDailyChallenges();
            }
        });

        // Backpack button
        const backpackButton = document.querySelector('.backpack-button');
        const backpackScreen = document.querySelector('.backpack-screen');
        const closeBackpack = document.querySelector('.close-backpack');

        backpackButton.addEventListener('click', () => {
            this.updateBackpackDisplay();
            backpackScreen.classList.add('show');
        });

        closeBackpack.addEventListener('click', () => {
            backpackScreen.classList.remove('show');
        });

        // Zodiac button
        const zodiacButton = document.querySelector('.zodiac-button');
        const zodiacScreen = document.querySelector('.zodiac-screen');
        const closeZodiac = document.querySelector('.close-zodiac');

        zodiacButton.addEventListener('click', () => {
            this.updateZodiacDisplay();
            zodiacScreen.classList.add('show');
        });

        closeZodiac.addEventListener('click', () => {
            zodiacScreen.classList.remove('show');
        });

        // Reset data button
        const resetButton = document.createElement('button');
        resetButton.className = 'reset-data-button';
        resetButton.innerHTML = '<i class="fas fa-trash"></i>';
        resetButton.style.position = 'fixed';
        resetButton.style.bottom = '20px';
        resetButton.style.right = '20px';
        resetButton.style.zIndex = '1000';
        resetButton.addEventListener('click', () => {
            if (confirm('Bạn có chắc chắn muốn xóa tất cả dữ liệu?')) {
                localStorage.clear();
                location.reload();
            }
        });
        document.body.appendChild(resetButton);

        // Initialize backpack slots
        const backpackSlots = document.querySelector('.backpack-slots');
        for (let i = 0; i < 6; i++) {
            const slot = document.createElement('div');
            slot.className = 'backpack-slot';
            slot.dataset.index = i;
            slot.addEventListener('click', () => this.handleBackpackSlotClick(i));
            backpackSlots.appendChild(slot);
        }

        // Initialize zodiac grid
        const zodiacGrid = document.querySelector('.zodiac-grid');
        for (let i = 0; i < 12; i++) {
            const slot = document.createElement('div');
            slot.className = 'zodiac-slot locked';
            slot.dataset.index = i;
            const img = document.createElement('img');
            img.src = `assets/img/hidden-${i + 1}.png`;
            img.alt = this.zodiacSigns[i].name;
            slot.appendChild(img);
            zodiacGrid.appendChild(slot);
        }
    }

    updateBackpackDisplay() {
        const moneyDisplay = document.querySelector('.money-display span');
        moneyDisplay.textContent = this.backpack.money;

        const slots = document.querySelectorAll('.backpack-slot');
        this.backpack.items.forEach((item, index) => {
            const slot = slots[index];
            if (item) {
                slot.classList.add('has-item');
                slot.innerHTML = `
                    <img src="assets/img/${item.id}.png" alt="${item.name}">
                    <span class="item-count">x${item.count}</span>
                `;
            } else {
                slot.classList.remove('has-item');
                slot.innerHTML = '';
            }
        });
    }

    updateZodiacDisplay() {
        const slots = document.querySelectorAll('.zodiac-slot');
        this.collectedZodiacs.forEach((count, index) => {
            const slot = slots[index];
            const img = slot.querySelector('img');
            const zodiac = this.zodiacSigns[index];

            if (count > 0) {
                // Check if this is a newly unlocked zodiac
                const wasLocked = slot.classList.contains('locked');
                slot.classList.remove('locked');

                if (wasLocked) {
                    // Add newly-unlocked class for animation
                    slot.classList.add('newly-unlocked');
                    // Remove the class after animation completes
                    setTimeout(() => {
                        slot.classList.remove('newly-unlocked');
                    }, 500);
                }

                // Add rarity class
                slot.classList.add(zodiac.rarity);

                img.src = `assets/img/${index + 1}.png`;
                if (count > 1) {
                    const countSpan = document.createElement('span');
                    countSpan.className = 'zodiac-count';
                    countSpan.textContent = `x${count}`;
                    slot.appendChild(countSpan);
                }
            } else {
                slot.classList.add('locked');
                slot.classList.remove('common', 'rare', 'epic');
                img.src = `assets/img/hidden-${index + 1}.png`;
                const countSpan = slot.querySelector('.zodiac-count');
                if (countSpan) countSpan.remove();
            }
        });
    }

    handleBackpackSlotClick(index) {
        const item = this.backpack.items[index];
        if (item) {
            // Show confirmation popup
            const confirmPopup = document.createElement('div');
            confirmPopup.className = 'challenge-complete';
            confirmPopup.innerHTML = `
                <div class="challenge-content">
                    <i class="fas fa-gift"></i>
                    <h3>Mở Hộp Quà Đặc Biệt</h3>
                    <p>Bạn có muốn mở hộp quà đặc biệt không?</p>
                    <div class="challenge-rewards">
                        <div class="reward-item">
                            <i class="fas fa-gift"></i>
                            <span>Hộp quà đặc biệt x1</span>
                        </div>
                    </div>
                    <div class="game-over-buttons">
                        <button class="game-over-button play-again">Có</button>
                        <button class="game-over-button close">Không</button>
                    </div>
                </div>
            `;

            document.body.appendChild(confirmPopup);
            playSound('click', 0.5);

            // Handle button clicks
            const yesButton = confirmPopup.querySelector('.play-again');
            const noButton = confirmPopup.querySelector('.close');

            yesButton.addEventListener('click', () => {
                confirmPopup.remove();
                // Increment special presents opened counter
                if (typeof currentGameState !== 'undefined') {
                    currentGameState.specialPresentsOpened++;
                    // Check for challenge completion
                    const challengeKey = 'openSpecialPresent';
                    if (currentGameState.dailyChallenges[challengeKey] &&
                        !currentGameState.dailyChallenges[challengeKey].completed) {
                        currentGameState.dailyChallenges[challengeKey].completed = true;
                        showCompletionNotification(currentGameState.dailyChallenges[challengeKey]);
                    }
                }
                this.showWheelOfFortune(item);
            });

            noButton.addEventListener('click', () => {
                confirmPopup.remove();
            });
        }
    }

    showWheelOfFortune(item) {
        // Decrease present count
        item.count--;

        // Remove item if count reaches 0
        if (item.count <= 0) {
            const itemIndex = this.backpack.items.findIndex(i => i === item);
            if (itemIndex !== -1) {
                this.backpack.items[itemIndex] = null;
            }
        }

        this.updateBackpackDisplay();
        this.saveData();

        const casePopup = document.createElement('div');
        casePopup.className = 'challenge-complete case-popup';
        casePopup.innerHTML = `
            <div class="challenge-content">
                <div class="case-container">
                    <div class="case-items">
                        ${Array(24).fill(0).map((_, i) =>
            this.zodiacSigns.map((sign, index) => `
                                <div class="case-item" data-rarity="${sign.rarity}">
                                    <img src="assets/img/hidden-${index + 1}.png" alt="${sign.name}">
                                </div>
                            `).join('')
        ).join('')}
                    </div>
                    <div class="case-pointer"></div>
                </div>
                <button class="spin-button">Mở Hộp</button>
            </div>
        `;

        document.body.appendChild(casePopup);
        playSound('click', 0.5);

        const caseItems = casePopup.querySelector('.case-items');
        const spinButton = casePopup.querySelector('.spin-button');
        let isSpinning = false;

        spinButton.addEventListener('click', () => {
            if (isSpinning) return;
            isSpinning = true;
            spinButton.disabled = true;

            // Calculate total probability
            const totalProb = this.zodiacSigns.reduce((sum, sign) => sum + sign.rate, 0);

            // Select zodiac based on rates
            const rand = Math.random() * totalProb;
            let cumulativeProb = 0;
            let selectedZodiac = null;

            for (const zodiac of this.zodiacSigns) {
                cumulativeProb += zodiac.rate;
                if (rand <= cumulativeProb) {
                    selectedZodiac = zodiac;
                    break;
                }
            }

            // Fallback to first common zodiac if somehow nothing was selected
            if (!selectedZodiac) {
                selectedZodiac = this.zodiacSigns.find(sign => sign.rarity === 'common');
            }

            // Calculate animation parameters
            const itemWidth = 150; // Width of each item in pixels
            const totalItems = this.zodiacSigns.length;
            const itemsPerLoop = totalItems * 2; // Double the items for smoother loop
            const baseLoops = 3; // Minimum number of full loops
            const randomLoops = Math.floor(Math.random() * 3); // 0-2 additional loops
            const totalLoops = baseLoops + randomLoops;

            // Calculate the final position to stop at the selected zodiac
            const selectedIndex = this.zodiacSigns.findIndex(z => z.id === selectedZodiac.id);
            const finalPosition = (totalLoops * itemsPerLoop * itemWidth) + (selectedIndex * itemWidth);

            // Start with fast animation
            caseItems.style.transition = 'transform 0.5s linear';
            caseItems.style.transform = `translateX(-${itemWidth * 4}px)`; // Initial quick movement

            // After initial movement, start the main spinning animation
            setTimeout(() => {
                // Add a slight delay before the main animation to create tension
                setTimeout(() => {
                    caseItems.style.transition = `transform ${3 + randomLoops * 0.5}s cubic-bezier(0.21, 0.53, 0.29, 0.99)`;
                    caseItems.style.transform = `translateX(-${finalPosition}px)`;

                    // Add a subtle glow effect to the pointer during animation
                    const pointer = casePopup.querySelector('.case-pointer');
                    pointer.style.boxShadow = '0 0 20px rgba(255, 215, 0, 0.5)';
                    pointer.style.transition = 'box-shadow 0.3s ease-in-out';

                    // After spinning animation completes
                    setTimeout(() => {
                        // Remove the glow effect
                        pointer.style.boxShadow = 'none';

                        // Show result with flip animation
                        this.showZodiacResult(selectedZodiac, casePopup);
                    }, (3 + randomLoops * 0.5) * 1000);
                }, 200);
            }, 500);
        });
    }

    showZodiacResult(zodiac, casePopup) {
        const resultPopup = document.createElement('div');
        resultPopup.className = 'challenge-complete';
        resultPopup.style.zIndex = '2000';
        resultPopup.innerHTML = `
            <div class="challenge-content">
                <div class="zodiac-result">
                    <div class="zodiac-card ${zodiac.rarity}">
                        <div class="card-front">
                            <img src="assets/img/hidden-${zodiac.id}.png" alt="${zodiac.name}">
                        </div>
                        <div class="card-back">
                            <img src="assets/img/${zodiac.id}.png" alt="${zodiac.name}">
                        </div>
                    </div>
                </div>
                <h3>Chúc Mừng!</h3>
                <p>Bạn đã nhận được ${zodiac.name}!</p>
                <p class="rarity-text ${zodiac.rarity}">${this.getRarityText(zodiac.rarity)}</p>
                <button class="close-challenge">Đóng</button>
            </div>
        `;

        document.body.appendChild(resultPopup);

        // Play different sounds based on rarity
        if (zodiac.rarity === 'epic') {
            playSound('rare', 1.0);
        } else if (zodiac.rarity === 'rare') {
            playSound('rare', 0.8);
        } else {
            playSound('common', 0.6);
        }

        // Update zodiac collection
        this.collectedZodiacs[zodiac.id - 1]++;

        // Update game state for challenges
        if (typeof currentGameState !== 'undefined') {
            // Calculate total counts from collectedZodiacs
            const totalCommon = this.collectedZodiacs.filter((_, i) => this.zodiacSigns[i].rarity === 'common').reduce((a, b) => a + b, 0);
            const totalRare = this.collectedZodiacs.filter((_, i) => this.zodiacSigns[i].rarity === 'rare').reduce((a, b) => a + b, 0);
            const totalEpic = this.collectedZodiacs.filter((_, i) => this.zodiacSigns[i].rarity === 'epic').reduce((a, b) => a + b, 0);

            // Update game state with new totals
            currentGameState.uncommonZodiacsCollected = totalCommon;
            currentGameState.rareZodiacsCollected = totalRare;
            currentGameState.epicZodiacsCollected = totalEpic;

            // Save the updated state
            saveGameState();

            // Check for challenge completion based on rarity
            if (zodiac.rarity === 'common' && totalCommon === 3) {
                const challengeKey = 'threeUncommonZodiacs';
                if (currentGameState.dailyChallenges[challengeKey] &&
                    !currentGameState.dailyChallenges[challengeKey].completed) {
                    currentGameState.dailyChallenges[challengeKey].completed = true;
                    currentGameState.currentScore += currentGameState.dailyChallenges[challengeKey].reward;
                    
                    // Show completion notification using the common function
                    showCompletionNotification(currentGameState.dailyChallenges[challengeKey]);

                    // Save updated challenges
                    const savedChallenges = localStorage.getItem('dailyChallenges');
                    if (savedChallenges) {
                        const parsed = JSON.parse(savedChallenges);
                        parsed.challenges = currentGameState.dailyChallenges;
                        localStorage.setItem('dailyChallenges', JSON.stringify(parsed));
                    }
                }
            } else if (zodiac.rarity === 'rare' && totalRare === 2) {
                const challengeKey = 'twoRareZodiacs';
                if (currentGameState.dailyChallenges[challengeKey] &&
                    !currentGameState.dailyChallenges[challengeKey].completed) {
                    currentGameState.dailyChallenges[challengeKey].completed = true;
                    currentGameState.currentScore += currentGameState.dailyChallenges[challengeKey].reward;
                    
                    // Show completion notification using the common function
                    showCompletionNotification(currentGameState.dailyChallenges[challengeKey]);

                    // Save updated challenges
                    const savedChallenges = localStorage.getItem('dailyChallenges');
                    if (savedChallenges) {
                        const parsed = JSON.parse(savedChallenges);
                        parsed.challenges = currentGameState.dailyChallenges;
                        localStorage.setItem('dailyChallenges', JSON.stringify(parsed));
                    }
                }
            } else if (zodiac.rarity === 'epic' && totalEpic === 1) {
                const challengeKey = 'oneEpicZodiac';
                if (currentGameState.dailyChallenges[challengeKey] &&
                    !currentGameState.dailyChallenges[challengeKey].completed) {
                    currentGameState.dailyChallenges[challengeKey].completed = true;
                    currentGameState.currentScore += currentGameState.dailyChallenges[challengeKey].reward;
                    
                    // Show completion notification using the common function
                    showCompletionNotification(currentGameState.dailyChallenges[challengeKey]);

                    // Save updated challenges
                    const savedChallenges = localStorage.getItem('dailyChallenges');
                    if (savedChallenges) {
                        const parsed = JSON.parse(savedChallenges);
                        parsed.challenges = currentGameState.dailyChallenges;
                        localStorage.setItem('dailyChallenges', JSON.stringify(parsed));
                    }
                }
            }
        }

        this.updateZodiacDisplay();
        this.saveData();

        // Log total zodiac counts after updating
        console.log('=== Tổng số cung hoàng đạo sau khi cập nhật ===');
        console.log('Thường:', this.collectedZodiacs.filter((_, i) => this.zodiacSigns[i].rarity === 'common').reduce((a, b) => a + b, 0));
        console.log('Hiếm:', this.collectedZodiacs.filter((_, i) => this.zodiacSigns[i].rarity === 'rare').reduce((a, b) => a + b, 0));
        console.log('Cực hiếm:', this.collectedZodiacs.filter((_, i) => this.zodiacSigns[i].rarity === 'epic').reduce((a, b) => a + b, 0));
        console.log('====================================');

        // Remove case popup
        casePopup.remove();

        // Add flip animation after a short delay
        setTimeout(() => {
            const card = resultPopup.querySelector('.zodiac-card');
            card.classList.add('flipped');

            // Create a container for confetti that will be above the backpack
            const confettiContainer = document.createElement('div');
            confettiContainer.className = 'confetti-container';
            confettiContainer.style.position = 'fixed';
            confettiContainer.style.top = '0';
            confettiContainer.style.left = '0';
            confettiContainer.style.width = '100%';
            confettiContainer.style.height = '100%';
            confettiContainer.style.zIndex = '1500'; // Between backpack and popup
            confettiContainer.style.pointerEvents = 'none';
            document.body.appendChild(confettiContainer);

            // Add confetti effect based on rarity
            if (zodiac.rarity === 'epic') {
                confetti({
                    particleCount: 200,
                    spread: 90,
                    origin: { y: 0.6 },
                    colors: ['#9C27B0', '#8e24aa', '#7B1FA2'],
                    zIndex: 1500
                });
            } else if (zodiac.rarity === 'rare') {
                confetti({
                    particleCount: 150,
                    spread: 80,
                    origin: { y: 0.6 },
                    colors: ['#2196F3', '#1e88e5', '#1976D2'],
                    zIndex: 1500
                });
            } else {
                confetti({
                    particleCount: 100,
                    spread: 70,
                    origin: { y: 0.6 },
                    zIndex: 1500
                });
            }

            // Remove confetti container after animation
            setTimeout(() => {
                confettiContainer.remove();
            }, 3000);
        }, 500);

        // Handle close button
        const closeButton = resultPopup.querySelector('.close-challenge');
        closeButton.addEventListener('click', () => {
            resultPopup.remove();
        });
    }

    getRarityText(rarity) {
        switch (rarity) {
            case 'common': return 'Thường';
            case 'rare': return 'Hiếm';
            case 'epic': return 'Siêu Hiếm';
            default: return '';
        }
    }

    addMoney(amount) {
        this.backpack.money += amount;
        this.updateBackpackDisplay();
        this.saveData();
    }

    addSpecialPresent() {
        // Find existing special present slot
        const presentSlot = this.backpack.items.find(item => item && item.id === 'present');

        if (presentSlot) {
            // If present exists, increment count
            presentSlot.count++;
        } else {
            // Find empty slot if no present exists
            const emptySlot = this.backpack.items.findIndex(item => item === null);
            if (emptySlot !== -1) {
                this.backpack.items[emptySlot] = {
                    id: 'present',
                    name: 'Hộp quà đặc biệt',
                    count: 1
                };
            }
        }
        this.updateBackpackDisplay();
        this.saveData();
    }

    saveData() {
        const data = {
            backpack: this.backpack,
            collectedZodiacs: this.collectedZodiacs
        };
        localStorage.setItem('zodiacData', JSON.stringify(data));
    }

    loadData() {
        const savedData = localStorage.getItem('zodiacData');
        if (savedData) {
            const data = JSON.parse(savedData);
            this.backpack = data.backpack;
            this.collectedZodiacs = data.collectedZodiacs;
            this.updateBackpackDisplay();
            this.updateZodiacDisplay();
        }
    }
}

// Initialize the zodiac system when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.zodiacSystem = new ZodiacSystem();
}); 