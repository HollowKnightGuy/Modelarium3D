import * as THREE from "three";
import { FontLoader } from "three/addons/loaders/FontLoader.js";
import { TextGeometry } from "three/addons/geometries/TextGeometry.js";
import Experience from "../Experience";


/**
 * Class that is responsible for setting the welcome text
 * @param  {string} name Name of the user
 * @return  {}
 * @author Pablo <pablogervilla123@gmail.com>
 */
export default class Usertext {
    constructor(name) {
        this.experience = new Experience();
        this.scene = this.experience.scene;
        this.loader = new FontLoader();
        this.name = name;
        this.lenghtname = name.length;
        this.size = 0.1;
        this.urlfont = new URL(
            "../../../public/fonts/BRLNSDB.json",
            import.meta.url
        );

        // Depending on the size the text size is different
        if (this.lenghtname > 20) this.size = 0.053;
        else if (this.lenghtname > 17) this.size = 0.058;
        else if (this.lenghtname > 14) this.size = 0.063;
        else if (this.lenghtname > 11) this.size = 0.069;
        else if (this.lenghtname > 8) this.size = 0.07;
        else if (this.lenghtname > 5) this.size = 0.08;
        this.setText();
    }


    /**
     * Create the 3D text
     * @param  {}
     * @return  {}
     */
    setText() {
        this.loader.load(
            this.urlfont,
            function (font) {
                const geometry = new TextGeometry(
                    "Hello " + this.name + ", Welcome !",
                    {
                        font: font,
                        size: this.size,
                        height: 0.02,
                    }
                );
                const textMesh = new THREE.Mesh(geometry, [
                    new THREE.MeshPhongMaterial({ color: 0xad4000 }),
                    new THREE.MeshPhongMaterial({ color: 0x5c2301 }),
                ]);

                textMesh.castShadow = true;
                textMesh.receiveShadow = true;
                this.scene.add(textMesh);
                textMesh.position.set(-0.7, 1, -0.9);
            }.bind(this)
        );
    }
}
