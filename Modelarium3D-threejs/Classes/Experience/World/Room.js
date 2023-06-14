import * as THREE from "three";
import Experience from "../Experience";

/**
 * Class that is responsible for setting properties for the 3D Models
 * @param  {}
 * @return  {}
 * @author Pablo <pablogervilla123@gmail.com>
 */
export default class Room {
    constructor() {
        this.experience = new Experience();
        this.scene = this.experience.scene;
        this.resources = this.experience.resources;
        this.room = this.resources.items.modeloFinal;
        this.actualRoom = this.room.scene;

        this.setModel();
    }


    /**
     * Sets the needed properties for each model
     * @param  {}
     * @return  {}
     */
    setModel() {
        this.actualRoom.children.forEach((child) => {
            child.castShadow = true;
            child.receiveShadow = true;

            // Set to each model the propertie to cast shadow and receive it
            if (child instanceof THREE.Group) {
                child.children.forEach((groupchild) => {
                    groupchild.castShadow = true;
                    groupchild.receiveShadow = true;
                });
            }

            // Set the transparent propertie for specific models
            else if (child.name == "mesa_cristal" || child.name == "cenicero") {
                child.material = new THREE.MeshStandardMaterial();
                child.material.transparent = true;
                if (child.name == "cenicero") {
                    child.material.opacity = 0.8;
                } else {
                    child.material.opacity = 0.5;
                }
            }
        });
        this.scene.add(this.actualRoom);
        this.actualRoom.scale.set(0.11, 0.11, 0.11);
    }
}
