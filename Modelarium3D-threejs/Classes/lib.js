import { Camera } from "three";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls";

let aceleration;
let times;
let xstep;
let ystep;
let zstep;
let xrstep;
let yrstep;
let zrstep;
let xorbstep;
let yorbstep;
let zorbstep;


/**
 * The library that can move the camera wherever you want
 * @param {Number} CamPosition 
 * @param {Number} FinalPoint 
 * @returns Number
 * @author Pablo <pablogervilla123@gmail.com>
 */
export default class lib {
    constructor() {

    }

    /**
     * Contemplates all cases of difference between the coordinate of the camera and that of the point
     * end to return a fraction of the way the camera should go correctly
     * @param {Number} CamPosition 
     * @param {Number} FinalPoint 
     * @returns Number
     */
    CamStepCalculator(CamPosition, FinalPoint) {
        let step;
        if (CamPosition < 0 && FinalPoint >= 0) {

            let xrdif = -CamPosition + FinalPoint;
            step = +xrdif / 500;
        }
        else if (CamPosition > 0 && FinalPoint > 0 && CamPosition > FinalPoint) {
            let xrdif = CamPosition - FinalPoint;
            step = -xrdif / 500;
        }
        else if (CamPosition > 0 && FinalPoint > 0 && CamPosition < FinalPoint) {
            let xrdif = FinalPoint - CamPosition;
            step = xrdif / 500;
        }
        else if (CamPosition >= 0 && FinalPoint < 0) {
            let xrdif = Math.abs(FinalPoint - CamPosition);
            step = -xrdif / 500;
        }
        else if (CamPosition < 0 && FinalPoint < 0 && FinalPoint > CamPosition) {
            let xrdif = Math.abs(CamPosition - FinalPoint);
            step = xrdif / 500;
        }
        else if (CamPosition < 0 && FinalPoint < 0 && FinalPoint < CamPosition) {
            let xrdif = Math.abs(CamPosition - FinalPoint);
            step = -xrdif / 500;
        }

        return step;
    }





    /**
   * It is in charge of changing the value of the coordinates of the camera position
   * @param {Camera} camera Camera used on the world
   * @param {OrbitControls} orbControls Controls used on the world
   * @param {Number} xs X step of the camera
   * @param {Number} ys Y step of the camera
   * @param {Number} zs Z step of the camera
   * @param {Number} xr X rotation step of the camera
   * @param {Number} yr Y rotation step of the camera
   * @param {Number} zr Z rotation step of the camera
   */
    changeCoordenates(camera, orbControls, xs, ys, zs, xr, yr, zr, xorb, yorb, zorb) {
        camera.position.x += xs;
        camera.position.y += ys;
        camera.position.z += zs;
        camera.rotation.x += xr;
        camera.rotation.y += yr;
        camera.rotation.z += zr;

        orbControls.target.x += xorb;
        orbControls.target.y += yorb;
        orbControls.target.z += zorb;
    }



    /**
     * It is responsible for cleaning the interval that has been passed
     * @param {Interval} interval Interval
     */
    deleteInterval(interval) {
        clearInterval(interval);
        document.body.style.cursor = "progress";
    }


    /**
 * Main function of camera movement
 * @param {Camera} camera Camera used on the world
 * @param {OrbitControls} orbControls Controls used on the world
 * @param {Number} x The camera coordinate that you want to reach on the x-axis
 * @param {Number} y The camera coordinate that you want to reach on the y-axis
 * @param {Number} z The camera coordinate that you want to reach on the z-axis
 * @param {Number} xr The camera rotation coordinate that you want to reach in the x-axis
 * @param {Number} yr The camera rotation coordinate that you want to reach in the y-axis
 * @param {Number} zr The camera rotation coordinate that you want to reach in the z-axis
 * @param {Number} xorb The controls rotation coordinate that you want to reach in the x-axis
 * @param {Number} yorb The controls rotation coordinate that you want to reach in the y-axis
 * @param {Number} zorb The controls rotation coordinate that you want to reach in the z-axis
 */
    moveCamera(camera, orbControls, x, y, z, xr = 0, yr = 0, zr = 0, xorb, yorb, zorb) {
        aceleration = 1;
        times = 0;
        if (times < 2) {
            xstep = this.CamStepCalculator(camera.position.x, x);
            ystep = this.CamStepCalculator(camera.position.y, y);
            zstep = this.CamStepCalculator(camera.position.z, z);
            xrstep = this.CamStepCalculator(camera.rotation.x, xr);
            yrstep = this.CamStepCalculator(camera.rotation.y, yr);
            zrstep = this.CamStepCalculator(camera.rotation.z, zr);
            xorbstep = this.CamStepCalculator(orbControls.target.x, xorb);
            yorbstep = this.CamStepCalculator(orbControls.target.y, yorb);
            zorbstep = this.CamStepCalculator(orbControls.target.z, zorb);
            console
        }
        const movcamara = setInterval(function () {
            if (times < 501) {
                if (times < 75) {
                    this.move_cam_aceleration(camera, orbControls, 0.039, xstep, ystep, zstep, xrstep, yrstep, zrstep, xorbstep, yorbstep, zorbstep);
                } else if (75 <= times && times < 300) {
                    this.move_cam_aceleration(camera, orbControls, 0.03, xstep, ystep, zstep, xrstep, yrstep, zrstep, xorbstep, yorbstep, zorbstep);
                } else if (300 <= times && times < 400) {
                    this.move_cam_aceleration(camera, orbControls, -0.08727, xstep, ystep, zstep, xrstep, yrstep, zrstep, xorbstep, yorbstep, zorbstep);
                } else {
                    this.move_cam_aceleration(camera, orbControls, - 0.01596517, xstep, ystep, zstep, xrstep, yrstep, zrstep, xorbstep, yorbstep, zorbstep);
                }
            } else {
                this.deleteInterval(movcamara);
            }
        }.bind(this), 1);
    }



    /**
* This function produces an aceleration on the movement of the camera
* @param {Camera} camera Camera used on the world
* @param {OrbitControls} orbControls Controls used on the world
* @param {Number} increment The increment on the speed
* @param {Number} xstep The camera numeric step on the x-axis
* @param {Number} ystep The camera numeric step on the y-axis
* @param {Number} zstep The camera numeric step on the z-axis
* @param {Number} xrstep The camera rotation numeric step on the x-axis
* @param {Number} yrstep The camera rotation numeric step on the y-axis
* @param {Number} zrstep The camera rotation numeric step on the z-axis
* @param {Number} xorbstep The controls rotation numeric step on the x-axis
* @param {Number} yorbstep The controls rotation numeric step on the y-axis
* @param {Number} zorbstep The controls rotation numeric step on the z-axis
*/
    move_cam_aceleration(camera, orbControls, increment, xstep, ystep, zstep, xrstep, yrstep, zrstep, xorbstep, yorbstep, zorbstep) {
        aceleration += increment;
        this.changeCoordenates(camera, orbControls, xstep * aceleration, ystep * aceleration, zstep * aceleration, xrstep * aceleration, yrstep * aceleration, zrstep * aceleration, xorbstep * aceleration, yorbstep * aceleration, zorbstep * aceleration);
        times += 1 * aceleration;
    }






}



