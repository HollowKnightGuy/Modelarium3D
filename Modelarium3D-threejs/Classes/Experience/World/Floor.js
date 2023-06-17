import * as THREE from "three";
import Experience from "../Experience";


/**
 * Class that is responsible for setting the floor and walls of the world
 * @param  {}
 * @return  {}
 * @author Pablo <pablogervilla123@gmail.com>
 */
export default class Floor {
    constructor() {
        this.experience = new Experience();
        this.scene = this.experience.scene;
        this.setFloor();
    }


    /**
     * Set the floor and walls
     * @param  {}
     * @return  {}
     */
    setFloor() {
        this.geometry = new THREE.PlaneGeometry(100, 100);
        this.material = new THREE.MeshStandardMaterial({
            color: 0xecb9ff,
            side: THREE.BackSide,
        });
        this.floor = new THREE.Mesh(this.geometry, this.material);
        this.scene.add(this.floor);
        this.floor.receiveShadow = true;
        this.floor.rotation.x = Math.PI / 2;

        this.geometry2 = new THREE.PlaneGeometry(100, 100);
        this.material2 = new THREE.MeshStandardMaterial({ color: 0xd791f3 });
        this.floor2 = new THREE.Mesh(this.geometry2, this.material2);
        this.scene.add(this.floor2);
        this.floor2.position.z = -10;

        this.geometry3 = new THREE.PlaneGeometry(100, 100);
        this.material3 = new THREE.MeshStandardMaterial({ color: 0xab66c6 });
        this.floor3 = new THREE.Mesh(this.geometry3, this.material3);
        this.scene.add(this.floor3);

        this.floor3.position.x = -10;
        this.floor3.rotation.y = Math.PI / 2;
    }
}
