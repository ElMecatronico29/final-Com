import { createApp } from 'vue/dist/vue.esm-bundler';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import axios from 'axios';
import Road from './components/Road.vue';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: process.env.MIX_PUSHER_PORT || 6001,
    wssPort: process.env.MIX_PUSHER_PORT || 6001,
    forceTLS: process.env.MIX_PUSHER_SCHEME === 'https',
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});

const app = createApp({
    components: {
        Road
    },
    data() {
        return {
            partidaCreada: false,
            raceInProgress: false,
            startTime: null,
            endTime: null,
            timerInterval: null,
            timeElapsed: '00:00:00',
            playerName: 'Creator',
            isCreator: false,
            playerCount: 1,
            enPartida:false,
            isCurrent : false,
            playerNumber:1,
            endGame:false
        }
    },
    methods: {
        async crearPartida() {
            try {
                this.isCurrent = true;
                await axios.post('/create', { creator: this.playerName });
                this.isCreator = true;
                this.enPartida = true;
            } catch (error) {
                console.error(error);
            }
        },
        async joinRace() {
            try {
                this.playerName = 'Player' + this.playerCount ;
                this.playerNumber = (this.playerCount +1);
                await axios.post('/join', { player: this.playerName }); // cambiar nombre
                this.enPartida = true;
            } catch (error) {
                console.error(error);
            }
        },
        async startRace() {
            try {
                await axios.post('/start', { creator: this.playerName });
                this.raceInProgress = true;
            } catch (error) {
                console.error(error);
            }
        },
        startTimer() {
            this.timerInterval = setInterval(() => {
                const now = new Date();
                const start = new Date(this.startTime);
                const diff = now - start;

                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                this.timeElapsed = `${this.pad(hours)}:${this.pad(minutes)}:${this.pad(seconds)}`;
            }, 1000);
        },
        stopTimer() {
            clearInterval(this.timerInterval);
            this.timerInterval = null;
        },
        pad(number) {
            return number < 10 ? '0' + number : number;
        },
        async handleKeydown(event) {
            if (this.isCreator && event.key === 'ArrowRight') {
                await axios.post('/move');
            }
        }
    },
    mounted() {
        window.addEventListener('keydown', this.handleKeydown);
        window.Echo.channel('raceUpdate')
            .listen('RaceUpdateMove', (e) => {
                    
                if (this.isCurrent) {
                    this.$refs.road.moveCar();
                }
                
            });
        window.Echo.channel('race')
            .listen('RaceStarted', (e) => {
                this.startTime = e.time;
                this.raceInProgress = true;
                this.startTimer();
            })
            .listen('RaceCreate', (e) => {
                this.partidaCreada=true;
            })
            .listen('RaceJoin', (e) => {
                this.playerCount ++;
            })
            .listen('RaceUpdate', (e) => {
                if (e.playerName === this.playerName) {
                    this.isCurrent = true; 
                }else{
                    this.isCurrent = false;
                }
            })
            .listen('endGame', (e) => {
                this.stopTimer();
                this.endGame = true;                
            });
    },
    beforeUnmount() {
        window.removeEventListener('keydown', this.handleKeydown);
    }
});

app.mount('#app');
