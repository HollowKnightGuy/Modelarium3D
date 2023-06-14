import * as THREE from "three";
import Experience from "../Experience";


/**
 * Class that is responsible for setting all the hitboxes of the interactive models
 * @param  {}
 * @return  {}
 * @author Pablo <pablogervilla123@gmail.com>
 */
export default class HoverGeoms {
    constructor() {
        this.experience = new Experience();
        this.scene = this.experience.scene;
        this.setHoverGeoms();
    }


    /**
     * Creates the hitboxes of the models
     * @param  {}
     * @return  {}
     */
    setHoverGeoms() {

        // Arcade Hitbox

        this.geometry = new THREE.BoxGeometry(0.37, 0.7, 0.37);
        this.material = new THREE.MeshStandardMaterial({
            color: 0x000000,
            transparent: true,
            opacity: 0,
        });
        this.arcadeHover = new THREE.Mesh(this.geometry, this.material);
        this.scene.add(this.arcadeHover);
        this.arcadeHover.position.set(-0.75, 0.4, 0.62);
        this.arcadeHover.name = "arcadehover";


        // PC Hitbox

        this.geometry = new THREE.BoxGeometry(0.4, 0.4, 0.6);
        this.material = new THREE.MeshStandardMaterial({
            color: 0x000000,
            transparent: true,
            opacity: 0,
        });
        this.PCHover = new THREE.Mesh(this.geometry, this.material);
        this.scene.add(this.PCHover);
        this.PCHover.position.set(-0.75, 0.2, 0);
        this.PCHover.name = "pchover";

        this.geometry = new THREE.BoxGeometry(0.05, 0.3, 0.3);
        this.material = new THREE.MeshStandardMaterial({
            color: 0x000000,
            transparent: true,
            opacity: 0,
        });
        this.Pantallahover = new THREE.Mesh(this.geometry, this.material);
        this.Pantallahover.name = "pantallahover";
        this.scene.add(this.Pantallahover);
        this.Pantallahover.position.set(-0.85, 0.4, 0.1);


        // Ipad Hitbox

        this.geometry = new THREE.BoxGeometry(0.2, 0.04, 0.2);
        this.material = new THREE.MeshStandardMaterial({
            color: 0x000000,
            transparent: true,
            opacity: 0,
        });
        this.Ipad = new THREE.Mesh(this.geometry, this.material);
        this.scene.add(this.Ipad);
        this.Ipad.name = "ipadhover";
        this.Ipad.position.set(0.24, 0.2, 0);
    }
}
