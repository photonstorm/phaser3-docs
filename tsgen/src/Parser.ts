import * as dom from "dts-dom"

const regexEndLine = /^.*((\r\n|\n|\r)|$)/gm

export class Parser {

    topLevel: dom.TopLevelDeclaration[];
    objects: { [key: string]: dom.DeclarationBase };

    constructor(docs:any[]) {

        // TODO remove once stable

        for(let i = 0; i < docs.length; i++) {

            let doclet = docs[i];

            if (doclet.longname.indexOf('~') != -1) {
                console.log(`Warning: weird doclet name: ${doclet.longname}, ignoring.`);
                docs.splice(i--, 1);
                continue;
            }
            var s:String = "";
            if(doclet.longname && doclet.longname.indexOf('{') === 0) doclet.longname = doclet.longname.substr(1);
            if(doclet.memberof && doclet.memberof.indexOf('{') === 0) doclet.memberof = doclet.memberof.substr(1);

            if(doclet.longname === 'EventEmitter') doclet.kind = "class";

            if(doclet.longname === 'project') docs.splice(i--, 1);// temporarily remove bad placement of a type

            if(doclet.longname === 'Phaser.Events.EventEmitter') doclet.augments = [];

            if(doclet.longname === 'Phaser.Renderer.WebGL.ForwardDiffuseLightPipeline#flush')
                docs.splice(i--, 1);

            if(doclet.longname === 'Phaser.Physics.Impact.Components.Collides#setActive')
                docs.splice(i--, 1);

            if(doclet.longname === 'Matter' && doclet.kind === 'member')// duplicate coming from CustomMain.js (namespace is defined properly)
                docs.splice(i--, 1);

        }

        //////////////////////////

        this.topLevel = [];
        this.objects = {};

        // parse doclets and create corresponding dom objects
        this.parseObjects(docs);

        this.resolveObjects(docs);

        // TODO: this isn't really the proper way here – removes members inherited from classes to prevent override errors
        this.resolveInheritance(docs);

        this.resolveParents(docs);

        // add integer alias
        this.topLevel.push(dom.create.alias('integer', dom.type.number));
        this.topLevel.push(dom.create.alias('int', dom.type.number));
        // declare type DOMHighResTimeStamp = number;
        this.topLevel.push(dom.create.alias('DOMHighResTimeStamp', dom.type.number));
        this.topLevel.push(dom.create.alias('Image', dom.create.namedTypeReference("HTMLImageElement")));
        this.topLevel.push(dom.create.alias('Point', dom.type.any));
        this.topLevel.push(dom.create.alias('SettingsObject', dom.type.any));
        this.topLevel.push(dom.create.alias('SettingsConfig', dom.type.any));
        let scenes:dom.NamespaceDeclaration = <dom.NamespaceDeclaration>this.objects["Phaser.Scenes"];
        scenes.members.push(dom.create.alias('SettingsConfig', dom.type.any));

        // add declare module
        const phaserPkgModuleDOM = dom.create.module('phaser');
        phaserPkgModuleDOM.members.push(dom.create.exportEquals('Phaser'));
        this.topLevel.push(phaserPkgModuleDOM);
    }

    emit() {
        let ignored = [];
        let result = this.topLevel.reduce((out:string, obj:dom.TopLevelDeclaration) => {
            //console.log(`Top Level – ${obj.kind} : ${(obj as any).name}`);
            // TODO: remove once stable
            if(<string>obj.kind === 'property') {
                ignored.push((<any>obj).name);
                return out;
            }
            //////////////////////////
            return out + dom.emit(obj)
        }, '');

        console.log('ignored top level properties:');
        console.log(ignored);

        return result;
    }

    private parseObjects(docs:any[]) {
        for(let i = 0; i < docs.length; i++) {

            let doclet = docs[i];

            if (this.objects[doclet.longname]) {
                console.log('Warning: ignoring duplicate doc name: '+doclet.longname);
                docs.splice(i--, 1);
                continue;
            }

            // TODO: Custom temporary rules
            switch(doclet.longname) {
                case "Phaser.GameObjects.Components.Alpha":
                case "Phaser.GameObjects.Components.BlendMode":
                case "Phaser.GameObjects.Components.ComputedSize":
                case "Phaser.GameObjects.Components.Depth":
                case "Phaser.GameObjects.Components.Flip":
                case "Phaser.GameObjects.Components.GetBounds":
                case "Phaser.GameObjects.Components.Origin":
                case "Phaser.GameObjects.Components.Pipeline":
                case "Phaser.GameObjects.Components.ScaleMode":
                case "Phaser.GameObjects.Components.ScrollFactor":
                case "Phaser.GameObjects.Components.ScaleFactor":
                case "Phaser.GameObjects.Components.Size":
                case "Phaser.GameObjects.Components.Texture":
                case "Phaser.GameObjects.Components.Tint":
                case "Phaser.GameObjects.Components.Transform":
                case "Phaser.GameObjects.Components.Visible":
                case "Phaser.GameObjects.Components.MatrixStack":
                    doclet.kind = "mixin";
                    break;
            }
            if((doclet.longname.indexOf("Phaser.Physics.Arcade.Components.") == 0
                || doclet.longname.indexOf("Phaser.Physics.Impact.Components.") == 0
                || doclet.longname.indexOf("Phaser.Physics.Matter.Components.") == 0)
                && doclet.longname.indexOf('#') == -1)
                doclet.kind = "mixin";
            /////////////////////////


            let obj:dom.DeclarationBase;
            switch(doclet.kind) {
                case 'namespace':
                    obj = this.createNamespace(doclet);
                    break;
                case 'class':
                    obj = this.createClass(doclet);
                    break;
                case 'mixin':
                    obj = this.createInterface(doclet);
                    break;
                case 'member':
                    if(doclet.isEnum === true) {
                        obj = this.createEnum(doclet);
                        break;
                    }
                case 'constant':
                    obj = this.createMember(doclet);
                    break;
                case 'function':
                    obj = this.createFunction(doclet);
                    break;
                case 'typedef':
                    obj = this.createTypedef(doclet);
                    break;
                default:
                    console.log("Ignored doclet kind: " + doclet.kind);
                    break;
            }

            if(obj) {
                this.objects[doclet.longname] = obj;
                if(doclet.description) {
                    let otherDocs = obj.jsDocComment || "";
                    obj.jsDocComment = doclet.description.match(regexEndLine).join('\n') + otherDocs;
                }
            }
        }
    }

    private resolveObjects(docs:any[]) {

        //TODO remove, make sure Phaser namespace exists
        if(!this.objects['Phaser']) {
            console.log(`Warning: had to create the Phaser namespace`);
            this.objects['Phaser'] = dom.create.namespace('Phaser');
            this.topLevel.push(<dom.TopLevelDeclaration>this.objects['Phaser']);
        }
        //////////////////

        let allTypes = new Set<string>();
        for(let doclet of docs) {
            let obj = this.objects[doclet.longname];

            if(!obj) {
                console.log(`Warning: Didn't find object for ${doclet.longname}`);
                continue;
            }


            if(!doclet.memberof) {
                this.topLevel.push(obj as dom.TopLevelDeclaration);
            } else {
                let parent = this.objects[doclet.memberof];

                //TODO: this whole section should be removed once stable
                if(!parent) {
                    console.log(`Creating missing parent ${doclet.memberof}`);
                    let parts:string[] = doclet.memberof.split('.');
                    let newParts = [parts.pop()];
                    while(parts.length > 0 && this.objects[parts.join('.')] == null) newParts.unshift(parts.pop());
                    console.log(`found ${parent} name: ${parts.join('.')} remaining ${newParts.join('.')}`);
                    parent = this.objects[parts.join('.')] as dom.NamespaceDeclaration;
                    if(parent == null) {
                        parent = dom.create.namespace(doclet.memberof);
                        if(this.objects[doclet.memberof]) console.log(`2:duplicate ${this.objects[doclet.memberof]}`);
                        this.objects[doclet.memberof] = parent;
                        this.topLevel.push(<dom.NamespaceDeclaration>parent);
                    } else {
                        while(newParts.length > 0) {
                            let oldParent = <dom.NamespaceDeclaration>parent;
                            parent = dom.create.namespace(newParts.shift());
                            console.log(`creating namespace ${(<any>parent).name}`);
                            parts.push((<dom.NamespaceDeclaration>parent).name);
                            if(this.objects[parts.join('.')]) console.log(`3:duplicate ${this.objects[parts.join('.')]}`);
                            this.objects[parts.join('.')] = parent;
                            oldParent.members.push(<dom.NamespaceDeclaration>parent);
                            (<any>parent)._parent = oldParent;
                        }
                    }
                }

                if(!(<any>parent).members) {
                    console.log(`parent doesn't have members:`);
                    console.log(parent);
                    continue;
                }
                ///////////////////////////////////////////////////////

                (<any>parent).members.push(obj);
                (<any>obj)._parent = parent;

                // class/interface members have methods, not functions
                if (((parent as any).kind === 'class' || (parent as any).kind === 'interface')
                    && (obj as any).kind === 'function')
                    (obj as any).kind = 'method';
            }

            if (doclet.kind === 'class') {
                let o = obj as dom.ClassDeclaration;

                let cstr:dom.ConstructorDeclaration = <dom.ConstructorDeclaration>o.members.find(m => m.kind == 'constructor');
                if(cstr)
                for(let param of cstr.parameters) {
                    if(!param.type) {
                        console.log(`param.type null:`);
                        console.log(param);
                    }
                    insertTypeNames(param.type);
                }
            } else if(doclet.kind === 'member' && !doclet.isEnum) {
                let o = obj as dom.PropertyDeclaration;
                if(!o.type) {
                    console.log(`o.type null:`)
                    console.log(obj);
                    console.log(doclet);
                }
                insertTypeNames(o.type);
            } else if(doclet.kind === 'function' || doclet.kind === 'method') {
                let o = obj as dom.MethodDeclaration | dom.FunctionDeclaration;
                if(!o) {
                    console.log(`obj as dom.MethodDeclaration | dom.FunctionDeclaration null:`)
                    console.log(obj);
                }
                for(let param of o.parameters) {
                    if(!param.type) {
                        console.log(`param.type null:`);
                        console.log(param);
                    }
                    insertTypeNames(param.type);
                }
                insertTypeNames(o.returnType);
            }
        }

        //TODO this remaining code should be removed once stable (inserts :any aliases for missing types)
        function insertTypeNames(type:dom.Type) {
            if((<any>type).kind === 'name') {
                doInsertTypeName((<dom.NamedTypeReference>type).name);
            } else if((<any>type).kind === 'union') {
                for(let member of (<dom.UnionType>type).members)
                    doInsertTypeName((<dom.NamedTypeReference>member).name);
            }
        }

        function doInsertTypeName(name) {
            while(name.indexOf('[]') != -1)
                name = name.slice(0, name.length - 2);
            switch(name){
                case "any":
                case "number":
                case "Function":
                case "object":
                case "integer":
                case "string":
                case "boolean":
                case "{[key: string]: Phaser.Cache.BaseCache}":
                case "null":
                case "*":
                case "DOMHighResTimeStamp":
                case "function()":
                case "int":
                case "HTMLCanvasElement":
                case "CanvasRenderingContext2D":
                case "symbol":
                case "Boolean":
                case "Float32Array":
                case "Object":
                case "Uint32Array":
                case "CanvasPattern":
                case "Number":
                case "KeyboardEvent":
                case "Event":
                case "undefined":
                case "ProgressEvent":
                case "Blob":
                case "XMLHttpRequest":
                case "WebGLRenderingContext":
                case "WebGLTexture":
                case "ArrayBuffer":
                case "WebGLBuffer":
                case "WebGLProgram":
                case "Uint8Array":
                case "WebGLFramebuffer":
                case "HTMLAudioElement":
                case "AudioBuffer":
                case "AudioBufferSourceNode":
                case "GainNode":
                case "AudioContext":
                case "AudioNode":

                    break;
                default:
                    allTypes.add(name);
            }
        }


        /*for(let typeName of allTypes) {
            if(typeName.indexOf('Phaser') == 0
                && (this.objects[typeName] === undefined
                    || (<any>this.objects[typeName]).kind == 'namespace'
                    || (<any>this.objects[typeName]).kind == 'function')
                && typeName != 'Phaser.Device' && typeName != 'Phaser.Physics.Impact.COLLIDES'
                && typeName !='Phaser.Physics.Matter.MatterTileBody') {
                console.log('Adding missing type as <any>: '+typeName);
                let lastDotIndex = typeName.lastIndexOf('.');
                let path = typeName.slice(0, lastDotIndex);
                let name = typeName.slice(lastDotIndex + 1);
                if(!this.objects[path]) {
                    let parts = path.split('.');
                    let namespace = null;
                    for(let i = 1; i <= parts.length; i++) {
                        let partialPath = parts.slice(0, i).join('.');
                        let innerNamespace = this.objects[partialPath];
                        if(innerNamespace === undefined) {
                            innerNamespace = dom.create.namespace(parts[i - 1]);
                            namespace.members.push(innerNamespace);
                            if(this.objects[partialPath]) console.log(`4:duplicate ${this.objects[partialPath]}`);
                            this.objects[partialPath] = innerNamespace;
                        }
                        namespace = innerNamespace;
                    }
                }
                // else {// is it just a namespace? is there the class for that too?
                //     let domObj = this.objects[path] as dom.NamespaceDeclaration | dom.ClassDeclaration;
                //     if(domObj.kind === 'namespace') {
                //         let parent = (<any>domObj)._parent;
                //         if(!parent) {
                //             console.log(`typename: ${typeName}`);
                //             console.log(`didn't find parent for:`);
                //             console.log(domObj);
                //         }
                //         if(!parent.members.find(obj => obj.name === name && obj.kind === 'class')) {
                //             let cls = dom.create.class(name);
                //             parent.members.push(cls);
                //             (<any>cls)._parent = parent;
                //         }
                //     }
                // }
                (this.objects[path] as dom.NamespaceDeclaration).members.push(
                    dom.create.alias(name, dom.type.any)
                );
            } else if(this.objects[typeName] === undefined) {
                this.topLevel.push(
                    dom.create.alias(typeName, dom.type.any)
                );
            }
        }*/
    }

    private resolveInheritance(docs:any[]) {
        for(let doclet of docs) {
            let obj = this.objects[doclet.longname];
            if(!obj) {
                console.log(`Didn't find type ${doclet.longname} ???`);
                continue;
            }
            if(!(<any>obj)._parent) continue;

            if(doclet.inherited) {
                let from = this.objects[doclet.inherits];
                if(!from || !(<any>from)._parent) {
                    console.log(`couldn't find inherited type: ${doclet.inherits}`);
                    continue;
                }
                if((<any>from)._parent.kind != 'interface') {
                    (<any>obj)._parent.members.splice((<any>obj)._parent.members.indexOf(obj), 1);
                    (<any>obj)._parent = null;
                }
            } else if(doclet.overrides || doclet.inherits) {
                let what = this.objects[doclet.overrides] as dom.FunctionDeclaration;
                let objFunction = obj as dom.FunctionDeclaration;
                if((what.parameters && what.parameters.length != objFunction.parameters.length)
                    || (what.returnType && what.returnType != objFunction.returnType)
                    || what.flags != objFunction.flags
                    || what.kind != objFunction.kind) {
                        console.log(`REMOVING INHERITED ${doclet.longname} from ${what.name}`);
                        (<any>obj)._parent.members.splice((<any>obj)._parent.members.indexOf(obj), 1);
                        (<any>obj)._parent = null;
                    }
            }
        }
    }

    private resolveParents(docs:any[]) {
        for(let doclet of docs) {
            let obj = this.objects[doclet.longname];

            if(!obj) {
                console.log('Didn\'t find object for '+doclet.longname);
                continue;
            }

            let parent = this.objects[doclet.memberof];

            if(!parent) {
                console.log(`Didn't find parent for: ${(<any>obj).name}`);
                continue;
            }

            // classes should be inside namespaces and properties inside classes
            let isNamespaceMember = doclet.kind === 'class' || doclet.isEnum || doclet.kind === 'typedef';
            let isMember = (doclet.kind === 'member' || doclet.kind === 'constant') && !doclet.isEnum;
            if((isNamespaceMember && (<any>parent).kind === 'class') ||
                (isMember && (<any>parent).kind === 'namespace')) {

                console.log(`moving to another parent type ${doclet.memberof} for member ${doclet.name}`);

                let requiredParentKind = (<any>parent).kind === 'class' ? 'namespace' : 'class';

                (<any>parent).members.splice((<any>parent).members.indexOf(obj), 1);// break old connection

                // find/create new class/namespace for property/class to sit in
                let parentNamespace:dom.NamespaceDeclaration = (<any>parent)._parent;

                let members;
                if(!parentNamespace) {
                    members = this.topLevel;
                    console.log(`didn't find parent for: `+(<any>parent).name);
                } else {
                    members = parentNamespace.members;
                }
                let properParent = members.find(nm => nm.kind === requiredParentKind
                    && nm.name === (<dom.NamespaceDeclaration|dom.ClassDeclaration>parent).name);
                if(!properParent) {
                    console.log(`Creating new parent.`);
                    properParent = requiredParentKind === 'class' ?
                        dom.create.class((<dom.NamespaceDeclaration>parent).name) :
                        dom.create.namespace((<dom.ClassDeclaration>parent).name);

                    members.push(properParent);
                }
                parent = properParent;

                // connect
                (<any>parent).members.push(obj);
                (<any>obj)._parent = parent;
            }


        }

        // now that parents are resolved, check augments
        for(let doclet of docs) { //TODO: Refactor duplication
            let obj = this.objects[doclet.longname];

            if(!obj) {
                console.log('Didn\'t find object for '+doclet.longname);
                continue;
            }

            let parent = this.objects[doclet.memberof];

            if(!parent) {
                console.log(`Didn't find parent for: ${(<any>obj).name}`);
                continue;
            }
            if (doclet.kind === 'class') {
                let o = obj as dom.ClassDeclaration;

                // resolve augments
                if (doclet.augments && doclet.augments.length) {
                    for(let i = 0; i < doclet.augments.length; i++) {

                        let baseType = this.objects[doclet.augments[i]] as dom.ClassDeclaration | dom.InterfaceDeclaration;

                        //TODO handle augment with type parameters

                        if (!baseType) {
                            console.log('ERROR: Did not find base type: '+doclet.augments[0]);
                        } else {
                            let qualifiedName = this.getQualifiedName(o, baseType);
                            if(baseType.kind == 'class') {
                                o.baseType = dom.create.class(qualifiedName);
                            } else {
                                o.implements.push(dom.create.interface(qualifiedName));
                            }
                        }
                    }
                }
            }
        }
    }

    private createNamespace(doclet:any):dom.NamespaceDeclaration {
        let obj = dom.create.namespace(doclet.name);

        return obj;
    }

    private createClass(doclet:any):dom.ClassDeclaration {
        let obj = dom.create.class(doclet.name);

        let params = null;
        if (doclet.params) {
            let ctor = dom.create.constructor(null);
            this.setParams(doclet, ctor);
            params = ctor.parameters;

            obj.members.push(ctor);
            (<any>ctor)._parent = obj;
        }

        this.processGeneric(doclet, obj, params);

        if(doclet.classdesc)
            doclet.description = doclet.classdesc.match(regexEndLine).join('\n'); // make sure docs will be added

        return obj;
    }

    private createInterface(doclet:any):dom.InterfaceDeclaration {
        return dom.create.interface(doclet.name);
    }

    private createMember(doclet:any):dom.PropertyDeclaration {
        let type = this.parseType(doclet);

        let obj = dom.create.property(doclet.name, type);

        this.processGeneric(doclet, obj, null);

        this.processFlags(doclet, obj);

        return obj;
    }

    private createEnum(doclet:any):dom.EnumDeclaration {
        let obj = dom.create.enum(doclet.name, false);

        this.processFlags(doclet, obj);

        return obj;
    }

    private createFunction(doclet:any):dom.FunctionDeclaration {
        let returnType:dom.Type = dom.type.void;

        if(doclet.returns) {
            returnType = this.parseType(doclet.returns[0]);
            // TODO temporary fix, remove when stable
            if((<dom.NamedTypeReference>returnType).name == doclet.longname)
                returnType = dom.type.any;
            /////////////////////////////////////////
        }

        let obj = dom.create.function(doclet.name, null, returnType);
        this.setParams(doclet, obj);

        this.processGeneric(doclet, obj, obj.parameters);

        this.processFlags(doclet, obj);

        return obj;
    }

    private createTypedef(doclet:any):dom.TypeAliasDeclaration {
        const typeName = doclet.type.names[0];
        let type = null;

        if(doclet.type.names[0] === 'object') {
            let properties = [];

            for(let propDoc of doclet.properties) {
                let prop = this.createMember(propDoc);
                properties.push(prop);
                if(propDoc.description)
                    prop.jsDocComment = propDoc.description.match(regexEndLine).join('\n');
            }

            type = dom.create.objectType(properties);

        } else {
            type = dom.create.functionType(null, dom.type.void);
            this.setParams(doclet, type);
        }

        let alias = dom.create.alias(doclet.name, type);

        this.processGeneric(doclet, alias, null);

        return alias;
    }

    private setParams(doclet:any, obj:dom.FunctionDeclaration|dom.ConstructorDeclaration):void {
        let parameters:dom.Parameter[] = [];

        if(doclet.params) {

            let optional = false;

            obj.jsDocComment = "";

            for(let paramDoc of doclet.params) {

                // TODO REMOVE TEMP FIX

                if(parameters.find((param) => param.name == paramDoc.name)) continue;

                if(paramDoc.name.indexOf('{') == 0) {
                    console.log('Warning: invalid param name in '+doclet.longname);
                    paramDoc.name = paramDoc.name.slice(1);
                }

                if(paramDoc.name.indexOf('.') != -1) {
                    console.log(`Warning: ignoring param with '.' in ${doclet.longname}`);

                    let defaultVal = paramDoc.defaultvalue !== undefined ? ` Default ${String(paramDoc.defaultvalue)}.` : '';
                    if(paramDoc.description)
                        obj.jsDocComment += `\n@param ${paramDoc.name} ${paramDoc.description.match(regexEndLine).join('\n')}` + defaultVal;
                    else if(defaultVal.length)
                        obj.jsDocComment += `\n@param ${paramDoc.name} ` + defaultVal;
                    continue;
                }

                if(paramDoc.name.startsWith('?')) {
                    console.log(`Removing ? from ${paramDoc.name} in ${doclet.longname}.`);
                    paramDoc.optional = true;
                    paramDoc.name = paramDoc.name.slice(1);
                }
                ///////////////////////

                let param = dom.create.parameter(paramDoc.name, this.parseType(paramDoc));
                parameters.push(param);

                if(optional && paramDoc.optional != true) {
                    console.log(`Correcting parameter ${paramDoc.name} in ${doclet.longname}, should be optional.`);
                    paramDoc.optional = true;
                }

                this.processFlags(paramDoc, param);

                optional = optional || paramDoc.optional === true;


                let defaultVal = paramDoc.defaultvalue !== undefined ? ` Default ${String(paramDoc.defaultvalue)}.` : '';

                if(paramDoc.description)
                    obj.jsDocComment += `\n@param ${paramDoc.name} ${paramDoc.description.match(regexEndLine).join('\n')}` + defaultVal;
                else if(defaultVal.length)
                    obj.jsDocComment += `\n@param ${paramDoc.name} ` + defaultVal;
            }
        }

        obj.parameters = parameters;
    }

    private parseType(typeDoc:any):dom.Type {
        if(!typeDoc || !typeDoc.type) {
            return dom.type.any;
        } else {
            let types = [];
            for(let name of typeDoc.type.names) {
                // TODO remove when stable

                if(name.indexOf('~') != -1) {
                    name = (<string>name).split('~').join('');
                }

                //if(name == '*') name = 'any';
                if(name.indexOf('*') != -1) {
                    name = (<string>name).split('*').join('any');
                }

                if(name.indexOf('function()') != -1) name = name.split('function()').join('Function');

                if(name == "Phaser.Renderer.WebGL.WebGLPipeline.FlatTintPipeline")
                    name = "Phaser.Renderer.WebGL.FlatTintPipeline";

                if(name == "Phaser.GameObjects.Components.TextStyle")
                    name = "Phaser.GameObjects.Text.TextStyle";

                if(name == "Phaser.Scenes.ScenePlugin#SceneTransitionConfig")
                    name = "Phaser.Scenes.ScenePlugin.SceneTransitionConfig";

                //////////////////////////
                if(name.indexOf('.<') != -1) {
                    name = (<string>name).split('.<').join('<');
                }

                let type = dom.create.namedTypeReference(this.processTypeName(name));

                types.push(type);
            }
            if(types.length == 1) return types[0];
            else return dom.create.union(types);
        }
    }

    private processTypeName(name:string):string {
        if(name === 'float') return 'number';
        if(name === 'function') return 'Function';
        if(name === 'array') return 'any[]';

        if (name.startsWith('Array<')) {
            let matches = name.match(/^Array<(.*)>$/);

            if (matches && matches[1]) {
                return this.processTypeName(matches[1])+'[]';
            }
        } else if(name.startsWith('Object<')) {
            let matches = name.match(/^Object<(.*)>$/);

            if (matches && matches[1]) {
                if(matches[1].indexOf(',') != -1) {
                    let parts = matches[1].split(',');
                    if(parts.length != 2) console.log('Warning: Object type application did not have 1 or 2 types.');
                    return `{[key: ${this.processTypeName(parts[0])}]: ${this.processTypeName(parts[1])}}`;
                } else {
                    return `{[key: string]: ${this.processTypeName(matches[1])}}`;
                }
            }
        }

        return name;
    }

    private processFlags(doclet:any, obj:dom.DeclarationBase|dom.Parameter) {
        obj.flags = dom.DeclarationFlags.None;
        if(doclet.variable === true) {
            obj.flags |= dom.ParameterFlags.Rest;
            let type:any = (<dom.Parameter>obj).type;
            if(!type.name.endsWith('[]')) {
                console.log(`Warning: ${doclet.name} rest parameter should be an array`);
                type.name = type.name + '[]'; // Must be an array
            }
        } else if (doclet.optional === true) {
            if (obj["kind"] === "parameter") obj.flags |= dom.ParameterFlags.Optional; // Rest implies Optional
            else obj.flags |= dom.DeclarationFlags.Optional; // Rest implies Optional
        }
        switch(doclet.access) {
            case "protected": obj.flags |= dom.DeclarationFlags.Protected; break;
            case "private": obj.flags |= dom.DeclarationFlags.Private; break;
        }
        if(doclet.kind === 'constant') obj.flags |= dom.DeclarationFlags.ReadOnly;
        if(doclet.scope === 'static') obj.flags |= dom.DeclarationFlags.Static;
    }

    private processGeneric(doclet:any, obj:dom.ClassDeclaration|dom.FunctionDeclaration|dom.PropertyDeclaration|dom.TypeAliasDeclaration, params:dom.Parameter[]) {
        if(doclet.tags)
        for(let tag of doclet.tags) {
            if(tag.originalTitle === 'generic') {
                let matches = (<string>tag.value).match(/(?:(?:{)([^}]+)(?:}))?\s?([^\s]+)(?:\s?-\s?(?:\[)(.+)(?:\]))?/);
                let typeParam = dom.create.typeParameter(matches[2], matches[1] == null ? null : dom.create.typeParameter(matches[1]));
                (<dom.ClassDeclaration|dom.FunctionDeclaration|dom.TypeAliasDeclaration>obj).typeParameters.push(typeParam);
                handleOverrides(matches[3], matches[2]);
            } else if(tag.originalTitle === 'genericUse') {
                let matches = (<string>tag.value).match(/(?:(?:{)([^}]+)(?:}))(?:\s?-\s?(?:\[)(.+)(?:\]))?/);
                let overrideType:string = matches[1];
                if(overrideType.indexOf('.<') != -1) {
                    overrideType = overrideType.split('.<').join('<');
                }
                handleOverrides(matches[2], this.processTypeName(overrideType));
            }
        }
        function handleOverrides(matchedString:string, overrideType:string) {
            if(matchedString != null) {
                let overrides = matchedString.split(',');
                if(params != null) {
                    for(let param of params)  {
                        if(overrides.indexOf(param.name) != -1) {
                            param.type = dom.create.namedTypeReference(overrideType);
                        }
                    }
                }
                if(overrides.indexOf('$return') != -1) {// has $return, must be a function
                    (<dom.FunctionDeclaration>obj).returnType = dom.create.namedTypeReference(overrideType);
                }
                if(overrides.indexOf('$type') != -1) {// has $type, must be a property
                    (<dom.PropertyDeclaration>obj).type =  dom.create.namedTypeReference(overrideType);
                }
            }
        }
    }

    private getQualifiedName(local:any, target:any):string {
        if(!local._parent) {
            console.log("didn't find parent in ");
            console.log(local);
        }
        let localFullPath = this.getFullyQualifiedName(local._parent);
        let targetFullPath = this.getFullyQualifiedName(target);
        if(targetFullPath.indexOf(localFullPath) == 0) {
            return targetFullPath.slice(localFullPath.length + 1);
        }
        return targetFullPath;
    }

    private getFullyQualifiedName(obj:any):string {
        let fullName = obj.name;
        while(obj._parent != null) {
            obj = obj._parent;
            fullName = obj.name+'.'+fullName;
        }
        return fullName;
    }

}
