document.addEventListener("DOMContentLoaded", function() {
    // Sélection du loader
    const loader = document.querySelector('.loader');

    // Cacher le loader une fois la page chargée
    loader.style.display = 'none';
});

const fs = `precision highp float;
uniform vec2 u_resolution;
uniform float u_time;

float droitePassantParSphere(vec3 origine,vec3 vecteurDirecteur,vec3 centre, float radius){
    float a = 
        (vecteurDirecteur.x * vecteurDirecteur.x) +
        (vecteurDirecteur.y * vecteurDirecteur.y) +
        (vecteurDirecteur.z * vecteurDirecteur.z);

    float b = 2.*
        (vecteurDirecteur.x *
            (origine.x-centre.x) + 
        vecteurDirecteur.y *
            (origine.y-centre.y) +
        vecteurDirecteur.z *
            (origine.z-centre.z));
    float c =
        (origine.x-centre.x)*(origine.x-centre.x) +
        (origine.y-centre.y)*(origine.y-centre.y) +
        (origine.z-centre.z)*(origine.z-centre.z);

    c -= radius*radius;

    float determinant = b*b - 4.*a*c;
    
    if(determinant == 0.0){
        return -b/(2.*a);
    }
    if(determinant > 0.0){
        float res1 = (-b-sqrt(determinant))/(2.*a);
        float res2 = (-b+sqrt(determinant))/(2.*a);

        return min(res1,res2);
    }
    return -1.;
}

vec3 parabole(float latitude,float longitude,float rayon){
    float x = rayon * cos(latitude) * cos(longitude);
    float y = rayon * cos(latitude) * sin(longitude);
    float z = rayon * sin(latitude);

    return vec3(x,y,z);
}

float plan(vec3 origine,vec3 vecteurDirecteur){
    return (1.-origine.y)/vecteurDirecteur.y;
}

float plan2(vec3 origine,vec3 vecteurDirecteur){
    return (-origine.x)/vecteurDirecteur.x;
}


vec3 rotateX(float angle,vec3 vector){
    mat3 matrix = mat3(
        1.,0.,0.,
        0.,cos(angle),-sin(angle),
        0.,sin(angle),cos(angle)
    );

    return vector * matrix;
}

vec3 rotateY(float angle,vec3 vector){
    mat3 matrix = mat3(
        cos(angle),0.,sin(angle),
        0.,1.,0.,
        -sin(angle),0.,cos(angle)
    );

    return vector * matrix;
}

vec3 rotateZ(float angle,vec3 vector){
    mat3 matrix = mat3(
        cos(angle),-sin(angle),0.,
        sin(angle),cos(angle),0.,
        0.,0.,1.
    );

    return vector * matrix;
}

vec3 translate(vec3 dir,vec3 vector) {
    return dir + vector;
}

float RayCaster(vec3 RayOrigin,vec3 RayDirection){
    float rad = 1.;
    float d=10000.;
    float a = droitePassantParSphere(RayOrigin,RayDirection,vec3(0.,0.,4.),rad);
    
    if(a>=0.){
        d=min(d,a);
    }

    a = droitePassantParSphere(RayOrigin,RayDirection,vec3(4.,0.,0.),rad);

    if(a>=0.){
        d=min(d,a);
    }

    a = droitePassantParSphere(RayOrigin,RayDirection,vec3(0.,0.,-4.),rad);

    if(a>=0.){
        d=min(d,a);
    }

    a = droitePassantParSphere(RayOrigin,RayDirection,vec3(-4.,0.,0.),rad);

    if(a>=0.){
        d=min(d,a);
    }

    a = droitePassantParSphere(RayOrigin,RayDirection,vec3(0.,4.,0.),rad);

    if(a>=0.){
        d=min(d,a);
    }

    a = droitePassantParSphere(RayOrigin,RayDirection,vec3(0.,-4.,0.),rad);

    if(a>=0.){
        d=min(d,a);
    }

    a = droitePassantParSphere(RayOrigin,RayDirection,vec3(4.,0.,4.),rad);

    if(a>=0.){
        d=min(d,a);
    }

    a = droitePassantParSphere(RayOrigin,RayDirection,vec3(-4.,0.,4.),rad);

    if(a>=0.){
        d=min(d,a);
    }

    a = droitePassantParSphere(RayOrigin,RayDirection,vec3(4.,0.,-4.),rad);

    if(a>=0.){
        d=min(d,a);
    }

    a = droitePassantParSphere(RayOrigin,RayDirection,vec3(-4.,0.,-4.),rad);

    if(a>=0.){
        d=min(d,a);
    }
    
    return d;
}

void main() {
    float fov = 30.;
    float imageRatio = u_resolution.x/u_resolution.y;
    vec2 NormalizedDeviceCoordinate = vec2((gl_FragCoord.xy+0.5)/u_resolution.xy);
    vec2 PixelScreen = 2.*NormalizedDeviceCoordinate -1.;
    PixelScreen.y = 1.- 2.*NormalizedDeviceCoordinate.y;
    PixelScreen.x *=imageRatio;
    PixelScreen *=tan(fov / 2.);

    vec3 cameraPixel = vec3(PixelScreen,2.);
    vec3 RayOrigin = vec3(0.,0.,0.);
    
    float a_time = radians(u_time);
    cameraPixel = rotateY(a_time,rotateZ(a_time,rotateY(radians(45.),translate(vec3(0.,20.,0.),rotateX(radians(90.),cameraPixel)))));
    
    RayOrigin = rotateY(a_time,rotateZ(a_time,rotateY(radians(45.),translate(vec3(0.,20.,0.),rotateX(radians(90.),RayOrigin)))));
    
    vec3 RayDirection = normalize(cameraPixel-RayOrigin);
    vec3 color = vec3(0.,0.,0.);
    float d = RayCaster(RayOrigin,RayDirection);

    if( d>=0.0 && d<1000. ){
        vec3 point = RayOrigin+RayDirection*d;
        color = vec3(normalize(point));
    }

    //color = abs(color);
    
    gl_FragColor = vec4(color, 1);
}`;

const vs = `
// an attribute will receive data from a buffer
  attribute vec4 a_position;

  // all shaders have a main function
  void main() {

    // gl_Position is a special variable a vertex shader
    // is responsible for setting
    gl_Position = a_position;
  }`;

function Context(context) {
  this.context = context;
  this.vertexShader = null;
  this.fragmentShader = null;
  this.program = null;

  const m = 184;
  this.context.canvas.style.width = m / 2 + "px";
  this.context.canvas.style.height = m / 2 + "px";

  this.attributes = [];
  this.uniforms = [];

  this.context.canvas.width = m * devicePixelRatio;
  this.context.canvas.height = m * devicePixelRatio;

  this.context.viewport(
    0,
    0,
    this.context.canvas.width,
    this.context.canvas.height
  );

  this.initializeRenderer();
  this.animation(0);
}

Context.prototype.createShader = function (type, code) {
  const shader = this.context.createShader(type);
  this.context.shaderSource(shader, code);
  this.context.compileShader(shader);

  const success = this.context.getShaderParameter(
    shader,
    this.context.COMPILE_STATUS
  );
  if (success) {
    return shader;
  }

  console.log(this.context.getShaderInfoLog(shader));
  this.context.deleteShader(shader);
};

Context.prototype.createVertexShader = function (code) {
  this.vertexShader = this.createShader(this.context.VERTEX_SHADER, code);
};

Context.prototype.createFragmentShader = function (code) {
  this.fragmentShader = this.createShader(this.context.FRAGMENT_SHADER, code);
};

Context.prototype.createProgram = function () {
  this.program = this.context.createProgram();
  this.context.attachShader(this.program, this.vertexShader);
  this.context.attachShader(this.program, this.fragmentShader);
  this.context.linkProgram(this.program);
  const success = this.context.getProgramParameter(
    this.program,
    this.context.LINK_STATUS
  );
  if (success) {
    this.context.useProgram(this.program);
    return;
  }

  console.log(this.context.getProgramInfoLog(this.program));
  this.context.deleteProgram(this.program);
};

/**
  @params name: Nom de la variable dans le shader.
  @params data: Les données des attributs à envoyer.
  @params metadata: Les métadonnées utilisés pour extraire
*/
Context.prototype.setAttribute = function (name, data, metadata) {
  const size = 2 || metadata.size;
  const type = this.context.FLOAT || metadata.type;
  const normalize = false;
  const stride = 0;
  const offset = 0;

  const location = this.context.getAttribLocation(this.program, name);
  const buffer = this.context.createBuffer();

  //We fill the buffer with data.
  this.context.bindBuffer(this.context.ARRAY_BUFFER, buffer);
  this.context.bufferData(
    this.context.ARRAY_BUFFER,
    data,
    this.context.STATIC_DRAW
  );

  const model = {
    size,
    type,
    normalize,
    stride,
    offset,
    location,
    buffer,
  };

  this.attributes.push(model);
};

Context.prototype.initializeViewport = function () {};

Context.prototype.defineDrawingView = function () {
  const triangles = [
    -1, -1, 1, -1, -1, 1,

    -1, 1, 1, 1, 1, -1,
  ];

  const data = new Float32Array(triangles);

  this.setAttribute("a_position", data);
};

Context.prototype.render = function (time = 0) {
  const attribute = this.attributes[0];

  this.context.clearColor(0, 0, 0, 0);
  this.context.clear(this.context.COLOR_BUFFER_BIT);
  this.context.uniform1f(this.uniforms[1].location, time);
  this.context.enableVertexAttribArray(attribute.location);
  this.context.bindBuffer(this.context.ARRAY_BUFFER, attribute.buffer);
  this.context.vertexAttribPointer(
    attribute.location,
    attribute.size,
    attribute.type,
    attribute.normalize,
    attribute.stride,
    attribute.offset
  );

  const primitiveType = this.context.TRIANGLES;
  const count = 6;
  this.context.drawArrays(primitiveType, attribute.offset, count);
};

Context.prototype.initializeRenderer = function () {
  this.createVertexShader(vs);
  this.createFragmentShader(fs);
  this.createProgram();

  const resolutionLocation = this.context.getUniformLocation(
    this.program,
    "u_resolution"
  );
  const timeLocation = this.context.getUniformLocation(this.program, "u_time");
  this.context.uniform2f(
    resolutionLocation,
    this.context.canvas.width,
    this.context.canvas.height
  );
  this.uniforms.push({ location: resolutionLocation });
  this.uniforms.push({ location: timeLocation });
  this.defineDrawingView();

  this.render();
};

Context.prototype.animation = function (t,a=0) {
  a = 4* t/(1000/60);
  this.render(a);
  window.requestAnimationFrame((t) => this.animation(t,a));
};

const canvas = document.getElementById("canvas");
const context = new Context(canvas.getContext("webgl"));

const centre = {
    x:1,
    y:2,
    z:-1
}

const radiusCarre = 14;

const origineDroite = {
    x:4,
    y:1,
    z:3
}

const vecteur = {
    x:1,
    y:-2,
    z:1
}
function sphere(centre,radiusCarre,origineDroite,vecteur){
    const a =
    vecteur.x * vecteur.x +
    vecteur.y * vecteur.y +
    vecteur.z * vecteur.z;
    const b = 2*
    ((vecteur.x*
        (origineDroite.x-centre.x)) +
    (vecteur.y*
        (origineDroite.y-centre.y)) +
    (vecteur.z*
        (origineDroite.z-centre.z)));


    const c = 
    ((centre.x-origineDroite.x)*(centre.x-origineDroite.x)) +
    ((centre.y-origineDroite.y)*(centre.y-origineDroite.y)) +
    ((centre.z-origineDroite.z)*(centre.z-origineDroite.z)) -
    radiusCarre;

   
}

sphere(centre,radiusCarre,origineDroite,vecteur);