<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrera Contra Reloj</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <div class="container">
            <h1>Carrera Contra Reloj</h1>
            <div v-if="!endGame">
                <div>
                    <button @click="crearPartida" v-if="!partidaCreada" >Crear Partida</button>
                </div>
                <div v-if="partidaCreada && isCreator" >
                    <button @click="startRace" v-if="!raceInProgress" >Iniciar Carrera</button>
                    <!-- <button @click="endRace" >Terminar Carrera</button>  -->
                </div>
                <div v-if="partidaCreada && !isCreator && !enPartida" >
                    <button @click="joinRace" >Unirme a partida</button>
                    <!-- <button @click="endRace" >Terminar Carrera</button>  -->
                </div>
                <div v-if="enPartida" >                
                    <h2>UsuarioConectados: @{{ playerCount }}</h2>
                </div>
                <div v-if="raceInProgress">
                    <h2 v-if="isCreator">Cronómetro: @{{ timeElapsed }}</h2>
                    <Road :show-car="isCurrent" :player-name="playerName" :player-count="playerCount" :player-number ="playerNumber" ref="road"/>
                </div>           
            </div>
            <div v-if="endGame">
                <h1>Juego Terminado</h1>
            </div>
            
        </div>
    </div>
</body>
</html>