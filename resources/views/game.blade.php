<!DOCTYPE html>
<html>
<head>
    <title>Game</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <div id="app">
        <div v-if="!game">
            <h1>Crear o Unirse a una Partida</h1>
            <input v-model="name" placeholder="Nombre del Juego">
            <input v-model="username" placeholder="Tu Nombre">
            <button @click="createGame">Crear Partida</button>
            <input v-model="gameId" placeholder="ID de la Partida">
            <button @click="joinGame">Unirse a la Partida</button>
        </div>
        <div v-if="game">
            <h2>Juego: {{ game.name }}</h2>
            <h3>Creador: {{ game.creator }}</h3>
            <h3>Jugadores:</h3>
            <ul>
                <li v-for="player in game.players" :key="player">{{ player }}</li>
            </ul>
            
            <div v-if="isCreator">
                <h3>Controla tu carro</h3>
                <div id="car" :style="{ left: carPosition + 'px' }">🚗</div>
                <button @click="moveCar">Avanzar</button>
            </div>

            <div v-else>
                <h3>Observa el carro del creador</h3>
                <div id="road">
                    <div v-for="section in roadSections" :key="section.id" :class="'road-section player-' + section.player">
                        <span v-if="section.player">{{ section.player }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
