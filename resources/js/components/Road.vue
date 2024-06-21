<template>
    <div id="road" >
        <div v-if="showCar" id="car"  :style="{ left: carPosition + 'px' }">🚗</div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    props: ['showCar','playerName','playerCount','playerNumber'],
    data() {
        return {
            carPosition: 0,
            carWidth: 60,
            playerNext: null
        };
    },
    methods: {
        async  moveCar() {           
            this.carPosition += 10;
            if (this.carPosition >= window.innerWidth - this.carWidth) {
                console.log(this.playerNumber);
                console.log(this.playerCount);
                if(this.playerNumber==this.playerCount){
                    const response = await axios.post('/endGame');
                }else{
                    this.playerNext = 'Player' + this.playerNumber ;
                    const response = await axios.post('/transport', {
                        playerName: this.playerNext // Accede al playerId desde el store Vuex
                    });
                    this.carPosition = 0;
                    this.cambios ++;
                }
                
            }
        },
    }
};
</script>

<style>
#road {
    width: 100%;
    height: 200px;
    border: 1px solid black;
    background-color: gray;
    position: relative;
    overflow: hidden;
}
#car {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    transition: left 0.1s;
    font-size: 2em;
    width: 50px
}
</style>
