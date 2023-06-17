import { EventEmitter } from "events";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";
import { DRACOLoader } from "three/examples/jsm/loaders/DRACOLoader.js";
import Experience from "../Experience.js";


/**
 * Class that is responsible for loading all the 3D Models
 * @param  {Array} assets All the 3D Models to load
 * @return  {}
 * @author Pablo <pablogervilla123@gmail.com>
 */
export default class Resources extends EventEmitter {
    constructor(assets) {
        super();
        this.experience = new Experience();
        this.renderer = this.experience.renderer;

        this.assets = assets;

        this.items = {};
        this.queue = this.assets.length;
        this.loaded = 0;

        this.setLoaders();
        this.startLoading();
    }


    /**
     * Initialize the 3D Model Loaders
     * @param  {}
     * @return  {}
     */
    setLoaders() {
        this.loaders = {};
        this.loaders.gltfLoader = new GLTFLoader();
        this.loaders.dracoLoader = new DRACOLoader();
        this.loaders.dracoLoader.setDecoderPath("/draco/");
        this.loaders.gltfLoader.setDRACOLoader(this.loaders.dracoLoader);
    }


    /**
     * Load the 3D Models
     * @param  {}
     * @return  {}
     */
    startLoading() {
        for (const asset of this.assets) {
            if (asset.type === "glbModel") {
                this.loaders.gltfLoader.load(asset.path, (file) => {
                    this.singleAssetLoaded(asset, file);
                });
            }
        }
    }


    /**
     * Load a 3D Model, when all are loaded it emits an event
     * @param  {Array} asset The properties of the 3D Model
     * @param  {String} file The path of the 3D Model
     * @return  {}
    */
   singleAssetLoaded(asset, file) {
        this.items[asset.name] = file;
        this.loaded++;
        if (this.loaded === this.queue) {
            this.emit("ready");
        }
    }
}
