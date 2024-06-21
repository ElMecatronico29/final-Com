<template>
    <div>
        <h1>Create Game</h1>
        <input type="text" v-model="username" placeholder="Enter your name">
        <input type="text" v-model="name" placeholder="Game Name">
        <button @click="createGame">Create</button>
        <input type="text" v-model="gameId" placeholder="Game ID (for joining)">
        <button @click="joinGame">Join Game</button>
        
        <div v-if="game">
            <h2>Game: {{ game.name }}</h2>
            <h3>Creator: {{ game.creator }}</h3>
            <h3>Players:</h3>
            <ul>
                <li v-for="player in game.players" :key="player">{{ player }}</li>
            </ul>
        </div>
    </div>
    
</template>

<script>
export default {
    data() {
        return {
            username: '',
            gameName: '',
            gameId: '',
            game: null
        };
    },
    methods: {
        async createGame() {
            try {
                const response = await axios.post('/game', {
                    name: this.gameName,
                    creator: this.username
                });
                this.game = response.data;
                console.log('Game created:', response.data);
            } catch (error) {
                console.error('Error creating game:', error);
            }
        },
        async joinGame() {
            try {
                const response = await axios.post(`/game/join/${this.gameId}`, {
                    username: this.username
                });
                this.game = response.data;
                console.log('Joined game:', response.data);
            } catch (error) {
                console.error('Error joining game:', error);
            }
        }

    }
};
</script>