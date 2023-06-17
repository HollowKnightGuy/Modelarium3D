import Experience from "../Experience.js";
import Room from './Room.js';
import Environment from './Environment.js';
import Floor from './Floor.js';

import Usertext from './UserText.js';
import HoverGeoms from './HoverGeoms.js';


/**
 * Class that is responsible for calling all the minor set up classes
 * @param  {string} name Name of the user
 * @return  {}
 * @author Pablo <pablogervilla123@gmail.com>
 */
export default class World{
    constructor(name){
        this.experience = new Experience();
        this.sizes = this.experience.sizes;
        this.scene = this.experience.scene;
        this.canvas = this.experience.canvas;
        this.camera = this.experience.camera;
        this.resources = this.experience.resources;
        
        
        this.resources.on("ready", () => {
            this.environment = new Environment();
            this.room = new Room();
            this.floor = new Floor();
            this.usertext = new Usertext(name);
            this.HoverGeoms = new HoverGeoms();
        })

    }
}