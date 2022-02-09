import axios from "axios";
import { Game } from '../classes/Game.js';

export function startGame(){
    axios.post('./gamestart/0')
    .then(Game.update());
}
