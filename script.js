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
        description: "✨ Một chú kỳ lân vàng hiếm có!",
        rarity: "rare"
    }
];

let currentGameState = {
    boxes: [],
    hasPicked: false,
    unlockedTeddies: {},
    teddyCounts: {}
};

function createBoxes() {
    const boxesContainer = document.querySelector('.boxes-container');
    const restartButton = document.getElementById('restartButton');
    
    boxesContainer.innerHTML = '';
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
}

function addUnlockedTeddy(teddy) {
    if (!currentGameState.unlockedTeddies[teddy.name]) {
        currentGameState.unlockedTeddies[teddy.name] = teddy;
        currentGameState.teddyCounts[teddy.name] = 1;
    } else {
        currentGameState.teddyCounts[teddy.name]++;
    }
    updateUnlockedDisplay();
}

function updateUnlockedDisplay() {
    const unlockedContainer = document.querySelector('.unlocked-container');
    unlockedContainer.innerHTML = '';

    Object.entries(currentGameState.unlockedTeddies).forEach(([name, teddy]) => {
        const count = currentGameState.teddyCounts[name];
        const unlockedItem = document.createElement('div');
        unlockedItem.className = 'unlocked-item';
        unlockedItem.innerHTML = `
            <i class="fas fa-bear"></i>
            <span class="teddy-name">${name}</span>
            <span class="teddy-count ${count > 1 ? 'show' : ''}">x${count}</span>
        `;
        unlockedContainer.appendChild(unlockedItem);
    });
}

function playSound(type) {
    const audio = new Audio(`assets/sound/${type}.mp3`);
    audio.play().catch(e => console.log("Lỗi phát âm thanh:", e));
}

function unboxTeddy(index) {
    if (currentGameState.hasPicked) return;

    const box = document.querySelector(`.box[data-index="${index}"]`);
    const unboxedTeddy = document.getElementById('unboxedTeddy');
    const teddyImage = document.getElementById('teddyImage');
    const teddyName = document.getElementById('teddyName');
    const teddyDescription = document.getElementById('teddyDescription');
    const boxesContainer = document.querySelector('.boxes-container');
    const restartButton = document.getElementById('restartButton');

    currentGameState.hasPicked = true;
    boxesContainer.classList.add('has-picked');
    box.classList.add('picked');
    restartButton.classList.add('show');

    const teddy = currentGameState.boxes[index];
    
    if (teddy.rarity === 'rare') {
        box.classList.add('secret');
        playSound('secret');
    } else {
        playSound('normal');
    }

    setTimeout(() => {
        addUnlockedTeddy(teddy);
        teddyImage.src = teddy.image;
        teddyName.textContent = teddy.name;
        teddyDescription.textContent = teddy.description;
        unboxedTeddy.style.display = 'block';

        if (teddy.rarity === 'rare') {
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 }
            });
        }
    }, 500);
}

document.addEventListener('click', (e) => {
    const unboxedTeddy = document.getElementById('unboxedTeddy');
    if (e.target === unboxedTeddy) {
        unboxedTeddy.style.display = 'none';
    }
});

document.getElementById('restartButton').addEventListener('click', () => {
    const unboxedTeddy = document.getElementById('unboxedTeddy');
    unboxedTeddy.style.display = 'none';
    currentGameState.hasPicked = false;
    createBoxes();
});

createBoxes(); 