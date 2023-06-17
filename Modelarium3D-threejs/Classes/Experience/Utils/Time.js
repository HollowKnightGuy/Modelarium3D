import { EventEmitter } from "events";


/**
 * Class that initialize the time variables needed to update the state of the room
 * @param  {}
 * @return  {}
 * @author Pablo <pablogervilla123@gmail.com>
 */
export default class Time extends EventEmitter {
    constructor() {
        super();
        this.start = Date.now();
        this.current = this.start;
        this.elapsed = 0;
        this.delta = 16;

        this.update();
    }


    /**
     * Responsible of emiting the 'update' event to update the state of the room
     * @param  {}
     * @return  {}
     */
    update() {
        const CurrentTime = Date.now();
        this.delta = CurrentTime - this.current;
        this.current = CurrentTime;
        this.elapsed = this.current - this.start;

        this.emit("update");
        window.requestAnimationFrame(() => this.update());
    }
}
