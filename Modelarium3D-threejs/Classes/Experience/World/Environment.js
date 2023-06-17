import * as THREE from "three";
import Experience from "../Experience";


/**
 * Class that is responsible for setting all the lights and shadows of the room
 * @param  {}
 * @return  {}
 * @author Pablo <pablogervilla123@gmail.com>
 */
export default class Environment {
    constructor() {
        this.experience = new Experience();
        this.scene = this.experience.scene;
        this.resources = this.experience.resources;

        this.setSunLight();
    }


    /**
     * Set the lights, shadows and shadowmap
     * @param  {}
     * @return  {}
     */
    setSunLight() {
        this.sunLight = new THREE.DirectionalLight("0x4c00e6", 0.7);
        this.sunLight.castShadow = true;
        this.sunLight.shadow.far = 2;
        this.sunLight.shadow.mapSize.set(8000, 8000);
        this.sunLight.shadow.normalBias = 0.02;
        this.sunLight.position.set(
            8.3843259671959975,
            2.5824498882850857,
            4.622222325920376
        );
        this.scene.add(this.sunLight);

        this.ambientlight = new THREE.AmbientLight("#aa80ff", 0.7);
        this.scene.add(this.ambientlight);
    }
}
