import { EventEmitter } from "events";
import * as THREE from "three";
import Experience from "../Experience.js";


/**
 * Class that is responsible for sending events for interactive functions
 * @param  {}
 * @return  {}
 * @author Pablo <pablogervilla123@gmail.com>
 */
export default class Movement extends EventEmitter {
    constructor() {
        super();
        this.originmovement = function () {
            this.emit("origen");
        };
        const experience = new Experience();
        const rayCaster = new THREE.Raycaster();
        const pointer = new THREE.Vector2();
        const bounds = document.body.getBoundingClientRect();


        /**
         * Function that handles the interactive click on the room
         * @param  {event} event The click properties
         * @return  {}
         */
        this.interactive = function (event) {
            var intersects = assignPointerPosition();
            for (let i = 0; i < intersects.length; i++) {
                let Objectname = intersects[i].object.name;
                // console.log(intersects[i].object.userData);
                if (Objectname == "pchover" || Objectname == "pantallahover") {
                    this.emit("ordenador");
                }
                if (Objectname == "arcadehover") {
                    this.emit("arcade");
                }
                if (Objectname == "ipadhover") {
                    this.emit("ipad");
                }
            }
        };


        /**
         * Function that handles the interactive hover on the room
         * @param  {event} event The hover properties
         * @return  {}
         */
        this.interactivehover = function (event) {
            var intersects = assignPointerPosition();
            let hover = false;
            for (let i = 0; i < intersects.length; i++) {
                let Objectname = intersects[i].object.name;
                if (
                    Objectname == "pchover" ||
                    Objectname == "pantallahover" ||
                    Objectname == "arcadehover" ||
                    Objectname == "ipadhover"
                ) {
                    hover = true;
                }
            }
            if (hover) {
                changeCursorState(true);
            } else {
                changeCursorState(false);
            }
        };


        /**
         * Assign to the pointer vector the position of the mouse
         * @param  {}
         * @return  {Array} The intersected objects
         */
        function assignPointerPosition() {
            pointer.x =
                ((event.clientX - bounds.left) / document.body.clientWidth) * 2 - 1;
            pointer.y =
                -((event.clientY - bounds.top) / document.body.clientHeight) * 2 + 1;
            rayCaster.setFromCamera(pointer, experience.camera.perspectiveCamera);
            var intersects = rayCaster.intersectObjects(
                experience.scene.children,
                true
            );
            return intersects;
        }


        /**
         * Change the styles of the cursor if its hovering a 3D Model
         * @param  {boolean} hover Says if its hovering or not a 3D Model
         * @return  {}
         */
        function changeCursorState(hover) {
            if (hover) {
                document.body.style.cursor = "none";
                document.getElementById("cursor").className = "block";
            } else {
                document.body.style.cursor = "auto";
                document.getElementById("cursor").className = "none";
            }
        }

        // EventListeners that calls the upper functions
        document.body.addEventListener("click", this.interactive.bind(this), false);
        document.body.addEventListener(
            "mousemove",
            this.interactivehover.bind(this),
            false
        );

        // document.querySelector("button").addEventListener('click', this.originmovement.bind(this));
    }
}
