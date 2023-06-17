import * as THREE from "three";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls.js";
import Movement from "./Utils/Movement.js";
import Experience from "./Experience";
import lib from "../lib.js";
import gsap from "gsap";
import { TimelineLite } from "gsap/all";


/**
 * Class that is responsible for setting up camera, controls, and camera functions
 * @param  {string}
 * @return  {}
 * @author Pablo <pablogervilla123@gmail.com>
 */
export default class Camera {
    constructor() {
        this.experience = new Experience();
        this.sizes = this.experience.sizes;
        this.scene = this.experience.scene;
        this.canvas = this.experience.canvas;
        this.movement = new Movement();
        this.lib = new lib();

        this.createPerspectiveCamera();
        this.createOrtographicCamera();
        this.setOrbitControls();

        // this.experience.presentation.on("1times", this.setOrbitControls())

        this.axes = new THREE.AxesHelper(5, 5, 5);
        // this.scene.add(this.axes)
    }


    /**
     * Create the camera, set its initial position, and bind functions to different events
     * @param  {}
     * @return  {}
     */
    createPerspectiveCamera() {
        this.perspectiveCamera = new THREE.PerspectiveCamera(
            35,
            this.sizes.aspect,
            0.1,
            1000
        );
        this.position = this.perspectiveCamera.position;
        this.rotation = this.perspectiveCamera.rotation;
        this.setCameraPosition();

        this.movement.on("ordenador", this.moveToPc.bind(this));
        this.movement.on("arcade", this.moveToArcade.bind(this));
        this.movement.on("ipad", this.moveToIpad.bind(this));
        this.movement.on("origen", this.moveToOrigin.bind(this));
        this.perspectiveCamera.updateProjectionMatrix();
    }


    /**
     * Function that using gsap make the animation of moving to the pc
     * Also redirect to the main page when the animation is finished
     * @param  {}
     * @return  {}
     */
    moveToPc() {
        this.controls.enabled = false;
        let tl = new TimelineLite({
            onComplete: function () {
                document.getElementById("pclink").click();
            },
        });
        gsap.to(this.perspectiveCamera.position, {
            x: -0.60219973482006,
            y: 0.5501302476000813,
            z: 0.10285366020236063,
            duration: 2,
            ease: "power3.inOut",
        });

        tl.to(this.controls.target, {
            x: -0.9417680921817115,
            y: 0.4603504952505593,
            z: 0.10787983270274792,
            duration: 2,
            ease: "power3.inOut",
        });
    }


    /**
     * Function that using gsap make the animation of moving to the Arcade
     * Also redirect to the contact page when the animation is finished
     * @param  {}
     * @return  {}
     */
    moveToArcade() {
        this.controls.enabled = false;
        let tl = new TimelineLite({
            onComplete: function () {
                document.getElementById("arcadelink").click();
            },
        });
        gsap.to(this.perspectiveCamera.position, {
            x: -0.31270755051079924,
            y: 0.5889805588759206,
            z: 0.6105217812838912,
            duration: 2,
            ease: "power3.inOut",
        });

        tl.to(this.controls.target, {
            x: -0.6365761707513888,
            y: 0.5528200874013415,
            z: 0.6150046391096257,
            duration: 2,
            ease: "power3.inOut",
        });
    }


    /**
     * Function that using gsap make the animation of moving to the ipad
     * Also redirect to the about us when the animation is finished
     * @param  {}
     * @return  {}
     */
    moveToIpad() {
        // this.controls.enabled = false;
        this.controls.maxAzimuthAngle = 10; // radians
        this.controls.minDistance = 0;

        let tl = new TimelineLite({
            onComplete: function () {
                document.getElementById("ipadlink").click();
            },
        });
        gsap.to(this.perspectiveCamera.position, {
            x: 0.26787700903856626,
            y: 0.4993919828785641,
            z: 0.0310226241524231,
            duration: 2,
            ease: "power3.inOut",
        });

        tl.to(this.controls.target, {
            x: 0.266251750688448,
            y: 0.2999051499004339,
            z: 0.0304243598714693,
            duration: 2,
            ease: "power3.inOut",
        });
    }


    /**
     * Function that using a custom library make the animation of moving to the original position of the camera
     * Also redirect to the main page when the animation is finished
     * @param  {}
     * @return  {}
     */
    moveToOrigin() {
        let camValues = this.setCameraPosition(true);
        let xorb = 0.0001;
        let yorb = 0.3001;
        let zorb = 0.0001;
        if (
            this.position.x != camValues[0] &&
            this.position.y != camValues[1] &&
            this.position.y != camValues[2]
        ) {
            if (
                this.controls.target.x === xorb ||
                this.controls.target.y === yorb ||
                this.controls.target.z === zorb
            ) {
                xorb = 0.001;
                yorb = 0.3;
                zorb = 0.001;
            }
            this.lib.moveCamera(
                this.perspectiveCamera,
                this.controls,
                camValues[0],
                camValues[1],
                camValues[2],
                -0.8517051944025393,
                0.5824676936125961,
                0.5609967955279564,
                xorb,
                yorb,
                zorb
            );
        }
        this.controls.enabled = true;
    }


    /**
     * Creates the ortographic camera which alternate the perspective of the 3D Models
     * @param  {}
     * @return  {}
     */
    createOrtographicCamera() {
        this.frustum = 5;
        this.ortographicCamera = new THREE.OrthographicCamera(
            (-this.sizes.aspect * this.sizes.frustum) / 2,
            (-this.sizes.aspect * this.sizes.frustum) / 2,
            this.sizes.frustum / 2,
            -this.sizes.frustum / 2,
            -50,
            50
        );
        this.scene.add(this.ortographicCamera);
    }


    /**
     * Sets the controls to move around the room
     * @param  {}
     * @return  {}
     */
    setOrbitControls() {
        this.controls = new OrbitControls(this.perspectiveCamera, this.canvas);
        this.controls.target.set(0.001, 0.3, 0.001);

        this.controls.minDistance = 0.3;
        this.controls.maxDistance = 8;
        this.controls.minAzimuthAngle = -Math.PI * 0.1; // radians
        this.controls.maxAzimuthAngle = Math.PI * 0.55; // radians
        this.controls.minPolarAngle = 0;
        this.controls.maxPolarAngle = Math.PI * 0.43;
        this.controls.enableDamping = true;
        this.controls.rotateSpeed = 0.1;
        this.controls.panSpeed = 0.3;
        this.controls.zoomSpeed = 0.8;
        this.controls.enableZoom = true;
        // this.controls.rotateSpeed = 1;
        // this.controls.panSpeed = 1;
        // this.controls.zoomSpeed = 2;
    }


    /**
     * Sets the original position of the camera depending on the screen size
     * If the camera is not set yet it will return the coordenates, else it will just zoom or zoomIn
     * @param  {boolean} returnSomething Determines if camera is already set
     * @return  {?Array} Coordenates
     */
    setCameraPosition(returnSomething = false) {
        if (300 <= this.sizes.width && this.sizes.width < 600) {
            if (this.sizes.width > 500) {
                this.setCamPosValues(3.5, 0.00723, false, 0.9);
            } else if (this.sizes.width > 400) {
                this.setCamPosValues(5.1, 0.00523, true, 0.5);
            } else {
                this.setCamPosValues(5.6, 0.00523, true, 0.3);
            }
        } else if (600 <= this.sizes.width && this.sizes.width < 1000) {
            if (this.sizes.width > 800) {
                this.setCamPosValues(2.6, 0.00723, false, 1.9);
            } else if (this.sizes.width > 700) {
                this.setCamPosValues(3, 0.00523, true, 1.3);
            } else {
                this.setCamPosValues(3.5, 0.00523, true, 0.8);
            }
        } else if (1000 <= this.sizes.width && this.sizes.width < 1440) {
            if (this.sizes.width > 1200) {
                this.setCamPosValues(2.9, 0.00723, true, 2.9);
            } else {
                this.setCamPosValues(2.7, 0.00523, true, 1.9);
            }
        } else if (1440 <= this.sizes.width && this.sizes.width < 2000) {
            if (this.sizes.width < 1760) {
                this.setCamPosValues(3.1, 0.00523, true, 2.4);
            } else {
                this.setCamPosValues(3.1, 0.00523, true, 3.3);
            }
        } else if (this.sizes.width >= 2000) {
            if (this.sizes.width > 2300) {
                this.setCamPosValues(2.8, 0.00323, true, 2.5);
            } else {
                this.setCamPosValues(3.1, 0.00523, true, 3.4);
            }
        }

        if (returnSomething) {
            return [this.x, this.y, this.z];
        } else {
            this.zoom(this.x, this.y, this.z);
        }
    }


    /**
     * Sets the controls to move around the room
     * @param  {Number} xz X and Z coordenate
     * @param  {Number} proportion Custom proportion to emulate a ratio
     * @param  {Boolean} sizesDiv Boolean that determines if the screen size is used to make the ratio
     * @param  {Number} modifier  Custom proportion to emulate a ratio
     * @return  {}
     */
    setCamPosValues(xz, proportion, sizesDiv, modifier) {
        if (sizesDiv) {
            this.x = xz;
            this.z = xz;
            this.y =
                this.sizes.width *
                ((proportion * this.sizes.width) / (this.sizes.width * modifier));
        } else {
            this.x = xz;
            this.z = xz;
            this.y = this.sizes.width * (proportion / modifier);
        }
    }


    /**
     * Zoom In and out
     * @param  {Number} xs X Coordenate
     * @param  {Number} ys X Coordenate
     * @param  {Number} zs X Coordenate
     * @return  {}
     */
    zoom(xs, ys, zs) {
        this.perspectiveCamera.position.x = this.x + (this.x - xs) * 1.2;
        this.perspectiveCamera.position.y = this.y + (this.y - ys) * 1.2;
        this.perspectiveCamera.position.z = this.z + (this.z - zs) * 1.2;
    }


    /**
     * Responsible of changing the aspect, and updatin the projection of the camera
     * @param {}
     * @return  {}
     */
    resize() {
        // Updating Perspective camera on Resize
        this.sizes.width = window.innerWidth;
        this.sizes.height = window.innerHeight;
        this.perspectiveCamera.aspect = this.sizes.aspect;
        this.perspectiveCamera.updateProjectionMatrix();
        this.setCameraPosition();

        this.ortographicCamera.updateProjectionMatrix();
        this.ortographicCamera.left = (-this.sizes.aspect * this.sizes.frustum) / 2;
        this.ortographicCamera.right =
            (-this.sizes.aspect * this.sizes.frustum) / 2;
        this.ortographicCamera.top = this.sizes.frustum / 2;
        this.ortographicCamera.bottom = -this.sizes.frustum / 2;
    }


    /**
     * Responsible of updating the controls when the aspect is changed
     * @param {}
     * @return  {}
     */
    update() {
        this.controls.update();
    }
}
