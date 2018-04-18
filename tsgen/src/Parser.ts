import * as dom from "dts-dom"

const regexEndLine = /^.*((\r\n|\n|\r)|$)/gm

export class Parser {

    topLevel: dom.TopLevelDeclaration[];
    objects: { [key: string]: dom.DeclarationBase };

    constructor(docs:any[]) {

        // TODO remove once stable
        for(let i = 0; i < docs.length; i++) {
            let doclet = docs[i];

            if(doclet.longname && doclet.longname.indexOf('{') === 0) {
                doclet.longname = doclet.longname.substr(1);
                console.log(`Warning: had to fix wrong name for ${doclet.longname} in ${doclet.meta.filename}@${doclet.meta.lineno}`);
            }
            if(doclet.memberof && doclet.memberof.indexOf('{') === 0) {
                doclet.memberof = doclet.memberof.substr(1);
                console.log(`Warning: had to fix wrong name for ${doclet.longname} in ${doclet.meta.filename}@${doclet.meta.lineno}`);
            }
        }
        //////////////////////////

        this.topLevel = [];
        this.objects = {};

        // parse doclets and create corresponding dom objects
        this.parseObjects(docs);

        this.resolveObjects(docs);

        // removes members inherited from classes
        // possibly could be avoided if mixins were defined as such before JSDoc parses them and then we could globally remove all inherited (not overriden) members globally from the parsed DB
        this.resolveInheritance(docs);

        this.resolveParents(docs);

        // add integer alias
        this.topLevel.push(dom.create.alias('integer', dom.type.number));

        // add declare module
        const phaserPkgModuleDOM = dom.create.module('phaser');
        phaserPkgModuleDOM.members.push(dom.create.exportEquals('Phaser'));
        this.topLevel.push(phaserPkgModuleDOM);
    }

    emit() {
        let ignored = [];
        let result = this.topLevel.reduce((out:string, obj:dom.TopLevelDeclaration) => {
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

            if (this.objects[doclet.longname]) {//TODO: coming from classes and namespaces having the same name
                console.log('Warning: ignoring duplicate doc name: '+doclet.longname);
                docs.splice(i--, 1);
                continue;
            }

            // TODO: Custom temporary rules
            switch(doclet.longname) {
                case "Phaser.GameObjects.Components.Alpha":
                case "Phaser.GameObjects.Components.Animation":
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
                    console.log(`${doclet.longname} in ${doclet.meta.filename}@${doclet.meta.lineno} has parent '${doclet.memberof}' that is not defined.`);
                    let parts:string[] = doclet.memberof.split('.');
                    let newParts = [parts.pop()];
                    while(parts.length > 0 && this.objects[parts.join('.')] == null) newParts.unshift(parts.pop());
                    parent = this.objects[parts.join('.')] as dom.NamespaceDeclaration;
                    if(parent == null) {
                        parent = dom.create.namespace(doclet.memberof);
                        this.objects[doclet.memberof] = parent;
                        this.topLevel.push(<dom.NamespaceDeclaration>parent);
                    } else {
                        while(newParts.length > 0) {
                            let oldParent = <dom.NamespaceDeclaration>parent;
                            parent = dom.create.namespace(newParts.shift());
                            parts.push((<dom.NamespaceDeclaration>parent).name);
                            this.objects[parts.join('.')] = parent;
                            oldParent.members.push(<dom.NamespaceDeclaration>parent);
                            (<any>parent)._parent = oldParent;
                        }
                    }
                }
                ///////////////////////////////////////////////////////

                (<any>parent).members.push(obj);
                (<any>obj)._parent = parent;

                // class/interface members have methods, not functions
                if (((parent as any).kind === 'class' || (parent as any).kind === 'interface')
                    && (obj as any).kind === 'function')
                    (obj as any).kind = 'method';
                // namespace members are vars or consts, not properties
                if ((parent as any).kind === 'namespace' && (obj as any).kind === 'property') {
                    if(doclet.kind == 'constant') (obj as any).kind = 'const';
                    else (obj as any).kind = 'var';
                }
            }
        }
    }

    private resolveInheritance(docs:any[]) {
        for(let doclet of docs) {
            let obj = this.objects[doclet.longname];
            if(!obj) {
                console.log(`Didn't find type ${doclet.longname} ???`);
                continue;
            }
            if(!(<any>obj)._parent) continue;

            if(doclet.inherited) {// remove inherited members if they aren't from an interface
                let from = this.objects[doclet.inherits];
                if(!from || !(<any>from)._parent)
                    throw `'${doclet.longname}' should inherit from '${doclet.inherits}', which is not defined.`;

                if((<any>from)._parent.kind != 'interface') {
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

            // classes should be inside namespaces
            let isNamespaceMember = doclet.kind === 'class' || doclet.isEnum || doclet.kind === 'typedef';
            if((isNamespaceMember && (<any>parent).kind === 'class')) {
                console.log(`moving to another parent type ${doclet.memberof} for member ${doclet.name}`);

                (<any>parent).members.splice((<any>parent).members.indexOf(obj), 1);// break old connection

                // find/create a namespace for class to sit in
                let parentNamespace:dom.NamespaceDeclaration = (<any>parent)._parent;

                let members;
                if(!parentNamespace) {
                    members = this.topLevel;
                    console.log(`didn't find parent for: `+(<any>parent).name);
                } else {
                    members = parentNamespace.members;
                }
                let properParent = members.find(nm => nm.kind === "namespace"
                    && nm.name === (<dom.NamespaceDeclaration|dom.ClassDeclaration>parent).name);
                if(!properParent) {
                    console.log(`Creating new parent.`);
                    properParent = dom.create.namespace((<dom.ClassDeclaration>parent).name);
                    members.push(properParent);
                }
                parent = properParent;

                // connect
                (<any>parent).members.push(obj);
                (<any>obj)._parent = parent;
            }


        }

        // now that parents are resolved, check augments
        for(let doclet of docs) {
            let obj = this.objects[doclet.longname];
            let parent = this.objects[doclet.memberof];
            if(!obj || !parent)
                continue;

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
                if(paramDoc.name.indexOf('.') != -1) {
                    console.log(`Warning: ignoring param with '.' for '${doclet.longname}' in ${doclet.meta.filename}@${doclet.meta.lineno}`);

                    let defaultVal = paramDoc.defaultvalue !== undefined ? ` Default ${String(paramDoc.defaultvalue)}.` : '';
                    if(paramDoc.description)
                        obj.jsDocComment += `\n@param ${paramDoc.name} ${paramDoc.description.match(regexEndLine).join('\n')}` + defaultVal;
                    else if(defaultVal.length)
                        obj.jsDocComment += `\n@param ${paramDoc.name} ` + defaultVal;
                    continue;
                }
                ///////////////////////

                let param = dom.create.parameter(paramDoc.name, this.parseType(paramDoc));
                parameters.push(param);

                if(optional && paramDoc.optional != true) {
                    console.log(`Warning: correcting to optional: parameter '${paramDoc.name}' for '${doclet.longname}' in ${doclet.meta.filename}@${doclet.meta.lineno}`);
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

                if(name.indexOf('*') != -1) {
                    name = (<string>name).split('*').join('any');
                }

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
                console.log(`Warning: rest parameter should be an array type for ${doclet.name}`);
                type.name = type.name + '[]'; // Must be an array
            }
        } else if (doclet.optional === true) {// Rest implies Optional – no need to flag it as such
            if (obj["kind"] === "parameter") obj.flags |= dom.ParameterFlags.Optional;
            else obj.flags |= dom.DeclarationFlags.Optional;
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
        if(!local._parent)
            throw `ERROR: Could not get qualified name because ${JSON.stringify(local)} does not have a parent`;
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
