import { EventEmitter } from 'events';


/**
 * Class that initialize all the sizes thar are needed in this project
 * @param  {}
 * @return  {}
 * @author Pablo <pablogervilla123@gmail.com>
 */
export default class Sizes extends EventEmitter {
    constructor() {
        super();
        this.width = window.innerWidth;
        this.height = window.innerHeight;
        this.aspect = this.width / this.height;
        this.pixelRatio = Math.min(window.devicePixelRatio, 2);

        window.addEventListener("resize", () => {
            this.width = window.innerWidth;
            this.height = window.innerHeight;
            this.aspect = this.width / this.height;
            this.pixelRatio = Math.min(window.devicePixelRatio, 2);
            this.emit("resize");
        });
    }
}