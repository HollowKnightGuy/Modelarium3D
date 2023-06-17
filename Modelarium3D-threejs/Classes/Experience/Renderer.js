import * as THREE from "three";
import Experience from "./Experience";

/**
 * Class that is responsible for rendering every single thing on a 3D space
 * @param  {}
 * @return  {}
 * @author Pablo <pablogervilla123@gmail.com>
 */
export default class Renderer {
    constructor() {
        this.experience = new Experience();
        this.sizes = this.experience.sizes;
        this.scene = this.experience.scene;
        this.canvas = this.experience.canvas;
        this.camera = this.experience.camera;

        this.setRenderer();
    }

    /**
     * Create and set the renderer
     * @param  {}
     * @return  {}
     */
    setRenderer() {
        this.renderer = new THREE.WebGL1Renderer({
            canvas: this.canvas,
            antialias: true,
        });

        this.renderer.physicallyCorrectLight = true;
        this.renderer.outputEncoding = THREE.sRGBEncoding;
        this.renderer.toneMapping = THREE.CineonToneMapping;
        this.renderer.toneMappingExposure = 1.75;
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        this.renderer.setSize(this.sizes.width, this.sizes.height);
        this.renderer.setPixelRatio(this.sizes.pixelRatio);
    }

    
    /**
     * Update the size of the renderer
     * @param  {}
     * @return  {}
     */
    resize() {
        this.renderer.setSize(this.sizes.width, this.sizes.height);
        this.renderer.setPixelRatio(this.sizes.pixelRatio);
        this.update();
    }


    /**
     * Update the renderer so that the room does not mess up
     * @param  {}
     * @return  {}
     */
    update() {
        this.renderer.render(this.scene, this.camera.perspectiveCamera);
    }
}
