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

class LeaderboardManager {
    constructor() {
        this.leaderboard = this.loadLeaderboard();
    }

    loadLeaderboard() {
        const saved = localStorage.getItem('teddyLeaderboard');
        return saved ? JSON.parse(saved) : [];
    }

    saveLeaderboard() {
        localStorage.setItem('teddyLeaderboard', JSON.stringify(this.leaderboard));
    }

    addScore(playerName, score, teddiesFound) {
        // Find existing player entry
        const existingPlayerIndex = this.leaderboard.findIndex(
            entry => entry.playerName.toLowerCase() === playerName.toLowerCase()
        );

        const entry = {
            playerName,
            score,
            teddies: teddiesFound,
            date: new Date().toLocaleDateString('vi-VN'),
            previousScore: null // Store previous score for display
        };

        if (existingPlayerIndex !== -1) {
            // Store the previous score before updating
            entry.previousScore = this.leaderboard[existingPlayerIndex].score;
            // Always update with the latest score
            this.leaderboard[existingPlayerIndex] = entry;
        } else {
            // Add new player
            this.leaderboard.push(entry);
        }

        // Sort by score (highest first)
        this.leaderboard.sort((a, b) => b.score - a.score);
        
        // Keep only top 10 scores
        if (this.leaderboard.length > 10) {
            this.leaderboard = this.leaderboard.slice(0, 10);
        }
        
        this.saveLeaderboard();
        return entry; // Return the entry for showing score change
    }

    getLeaderboard() {
        return this.leaderboard;
    }

    // Add method to check if a name exists
    isNameTaken(playerName) {
        return this.leaderboard.some(
            entry => entry.playerName.toLowerCase() === playerName.toLowerCase()
        );
    }
}

// Export for use in main script
window.LeaderboardManager = LeaderboardManager;
window.TEDDY_SCORES = TEDDY_SCORES; 