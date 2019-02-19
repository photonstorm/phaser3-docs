import * as dom from 'dts-dom';
import Guard from './Guard';

const regexEndLine = /^(.*)\r\n|\n|\r/gm;

export class Parser {

    topLevel: dom.TopLevelDeclaration[];
    objects: { [key: string]: dom.DeclarationBase };
    namespaces: { [key: string]: dom.NamespaceDeclaration };

    constructor(docs: Array<TDoclet>) {
        // TODO remove once stable
        for (let i = 0; i < docs.length; i++) {
            let doclet = docs[i];

            if (doclet.longname && doclet.longname.indexOf('{') === 0) {
                doclet.longname = doclet.longname.substr(1);
                console.log(`Warning: had to fix wrong name for ${doclet.longname} in ${doclet.meta.filename}@${doclet.meta.lineno}`);
            }
            if (doclet.memberof && doclet.memberof.indexOf('{') === 0) {
                doclet.memberof = doclet.memberof.substr(1);
                console.log(`Warning: had to fix wrong name for ${doclet.longname} in ${doclet.meta.filename}@${doclet.meta.lineno}`);
            }
        }
        //////////////////////////

        this.topLevel = [];
        this.objects = {};
        this.namespaces = {};

        // parse doclets and create corresponding dom objects
        this.parseObjects(docs);

        this.resolveObjects(docs);

        // removes members inherited from classes
        // possibly could be avoided if mixins were defined as such before JSDoc parses them and then we could globally remove all inherited (not
        // overriden) members globally from the parsed DB
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
        let result = this.topLevel.reduce((out: string, obj: dom.TopLevelDeclaration) => {
            // TODO: remove once stable
            if (<string>obj.kind === 'property') {
                ignored.push((<any>obj).name);
                return out;
            }
            //////////////////////////
            return out + dom.emit(obj);
        }, '');

        console.log('ignored top level properties:');
        console.log(ignored);

        return result;
    }

    private parseObjects(docs: Array<TDoclet>) {
        for (let i = 0; i < docs.length; i++) {

            let doclet = docs[i];

            // if (doclet.kind === 'namespace')
            // {
            //     console.log('module: ', doclet.name);
            // }

            // TODO: Custom temporary rules
            switch (doclet.longname) {
                case 'Phaser.GameObjects.Components.Alpha':
                case 'Phaser.GameObjects.Components.Animation':
                case 'Phaser.GameObjects.Components.BlendMode':
                case 'Phaser.GameObjects.Components.ComputedSize':
                case 'Phaser.GameObjects.Components.Crop':
                case 'Phaser.GameObjects.Components.Depth':
                case 'Phaser.GameObjects.Components.Flip':
                case 'Phaser.GameObjects.Components.GetBounds':
                case 'Phaser.GameObjects.Components.Mask':
                case 'Phaser.GameObjects.Components.Origin':
                case 'Phaser.GameObjects.Components.Pipeline':
                case 'Phaser.GameObjects.Components.ScaleMode':
                case 'Phaser.GameObjects.Components.ScrollFactor':
                case 'Phaser.GameObjects.Components.ScaleFactor':
                case 'Phaser.GameObjects.Components.Size':
                case 'Phaser.GameObjects.Components.Texture':
                case 'Phaser.GameObjects.Components.TextureCrop':
                case 'Phaser.GameObjects.Components.Tint':
                case 'Phaser.GameObjects.Components.ToJSON':
                case 'Phaser.GameObjects.Components.Transform':
                case 'Phaser.GameObjects.Components.Visible':
                    doclet.kind = 'mixin';
                    break;
            }
            if (doclet.longname == 'ModelViewProjection') doclet.kind = 'mixin';
            if ((doclet.longname.indexOf('Phaser.Physics.Arcade.Components.') == 0
                 || doclet.longname.indexOf('Phaser.Physics.Impact.Components.') == 0
                 || doclet.longname.indexOf('Phaser.Physics.Matter.Components.') == 0)
                && doclet.longname.indexOf('#') == -1)
                doclet.kind = 'mixin';
            /////////////////////////

            let obj: dom.DeclarationBase;
            let container = this.objects;

            switch (doclet.kind) {
                case 'namespace':
                    obj = this.createNamespace(doclet);
                    container = this.namespaces;
                    break;
                case 'class':
                    obj = this.createClass(doclet);
                    break;
                case 'mixin':
                    obj = this.createInterface(doclet);
                    break;
                case 'member':
                    if (doclet.isEnum === true) {
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
                case 'event':
                    obj = this.createEvent(doclet);
                    break;
                default:
                    console.log('Ignored doclet kind: ' + doclet.kind);
                    break;
            }

            if (obj) {
                if (container[doclet.longname]) {
                    console.log('Warning: ignoring duplicate doc name: ' + doclet.longname);
                    docs.splice(i--, 1);
                    continue;
                }
                container[doclet.longname] = obj;
                if (doclet.description) {
                    let otherDocs = obj.jsDocComment || '';
                    obj.jsDocComment = doclet.description.replace(regexEndLine, '$1\n') + otherDocs;
                }
            }
        }
    }

    private resolveObjects(docs: TDoclet[]) {
        let allTypes = new Set<string>();
        for (let doclet of docs) {
            let obj = doclet.kind === 'namespace' ? this.namespaces[doclet.longname] : this.objects[doclet.longname];

            if (!obj) {

                //  TODO
                console.log(`Warning: Didn't find object for ${doclet.longname}`);

                continue;
            }

            if (!doclet.memberof) {
                this.topLevel.push(obj as dom.TopLevelDeclaration);
            } else {
                let isNamespaceMember = doclet.kind === 'class' || doclet.kind === 'typedef' || doclet.kind == 'namespace' || ('isEnum' in doclet && doclet.isEnum);
                let parent = isNamespaceMember ? this.namespaces[doclet.memberof] : (this.objects[doclet.memberof] || this.namespaces[doclet.memberof]);

                //TODO: this whole section should be removed once stable
                if (!parent) {
                    console.log(`${doclet.longname} in ${doclet.meta.filename}@${doclet.meta.lineno} has parent '${doclet.memberof}' that is not defined.`);
                    let parts: string[] = doclet.memberof.split('.');
                    let newParts = [parts.pop()];
                    while (parts.length > 0 && this.objects[parts.join('.')] == null) newParts.unshift(parts.pop());
                    parent = this.objects[parts.join('.')] as dom.NamespaceDeclaration;
                    if (parent == null) {
                        parent = dom.create.namespace(doclet.memberof);
                        this.namespaces[doclet.memberof] = <dom.NamespaceDeclaration>parent;
                        this.topLevel.push(<dom.NamespaceDeclaration>parent);
                    } else {
                        while (newParts.length > 0) {
                            let oldParent = <dom.NamespaceDeclaration>parent;
                            parent = dom.create.namespace(newParts.shift());
                            parts.push((<dom.NamespaceDeclaration>parent).name);
                            this.namespaces[parts.join('.')] = <dom.NamespaceDeclaration>parent;
                            oldParent.members.push(<dom.NamespaceDeclaration>parent);
                            (<any>parent)._parent = oldParent;
                        }
                    }
                }
                ///////////////////////////////////////////////////////

                if ((<any>parent).members) {
                    (<any>parent).members.push(obj);
                } else {
                    console.log('Cannot find members array for:');
                    console.log(parent);
                }

                (<any>obj)._parent = parent;

                // class/interface members have methods, not functions
                if (((parent as any).kind === 'class' || (parent as any).kind === 'interface')
                    && (obj as any).kind === 'function')
                    (obj as any).kind = 'method';
                // namespace members are vars or consts, not properties
                if ((parent as any).kind === 'namespace' && (obj as any).kind === 'property') {
                    if (doclet.kind == 'constant') (obj as any).kind = 'const';
                    else (obj as any).kind = 'var';
                }
            }
        }
    }

    private resolveInheritance(docs: TDoclet[]) {
        for (let doclet of docs) {
            let obj = doclet.kind === 'namespace' ? this.namespaces[doclet.longname] : this.objects[doclet.longname];
            if (!obj) {

                //  TODO
                console.log(`Didn't find type ${doclet.longname} ???`);

                continue;
            }
            if (!(<any>obj)._parent) continue;

            if (doclet.inherited) {// remove inherited members if they aren't from an interface
                let from = this.objects[doclet.inherits];
                if (!from || !(<any>from)._parent)
                    throw `'${doclet.longname}' should inherit from '${doclet.inherits}', which is not defined.`;

                if ((<any>from)._parent.kind != 'interface') {
                    (<any>obj)._parent.members.splice((<any>obj)._parent.members.indexOf(obj), 1);
                    (<any>obj)._parent = null;
                }
            }
        }
    }

    private resolveParents(docs: Array<TDoclet>) {
        for (let doclet of docs) {
            let obj = this.objects[doclet.longname];
            if (!obj || doclet.kind !== 'class') continue;

            let o = obj as dom.ClassDeclaration;

            // resolve augments
            if (doclet.augments && doclet.augments.length) {
                for (let augment of doclet.augments) {
                    let name: string = this.prepareTypeName(augment);

                    let wrappingName = name.match(/[^<]+/s)[0];//gets everything up to a first < (to handle augments with type parameters)

                    let baseType = this.objects[wrappingName] as dom.ClassDeclaration | dom.InterfaceDeclaration;

                    if (!baseType) {
                        console.log(`ERROR: Did not find base type: ${augment} for ${doclet.longname}`);
                    } else {
                        if (baseType.kind == 'class') {
                            o.baseType = dom.create.class(name);
                        } else {
                            o.implements.push(dom.create.interface(name));
                        }
                    }
                }
            }
        }
    }

    private createNamespace(doclet: INamespaceDoclet): dom.NamespaceDeclaration {

        /**
         namespace: { comment: '',
        meta:
         { filename: 'index.js',
           lineno: 10,
           columnno: 0,
           path: '/Users/rich/Documents/GitHub/phaser/src/tweens',
           code: {} },
        kind: 'namespace',
        name: 'Tweens',
        memberof: 'Phaser',
        longname: 'Phaser.Tweens',
        scope: 'static',
        ___id: 'T000002R034468',
        ___s: true }
         */

            // console.log('namespace:', doclet.longname);

        let obj = dom.create.namespace(doclet.name);

        return obj;
    }

    private createClass(doclet: IClassDoclet): dom.ClassDeclaration {
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

        if (doclet.classdesc)
            doclet.description = doclet.classdesc.replace(regexEndLine, '$1\n'); // make sure docs will be added

        return obj;
    }

    private createInterface(doclet: IClassDoclet): dom.InterfaceDeclaration {
        return dom.create.interface(doclet.name);
    }

    private createMember(doclet: IMemberDoclet): dom.PropertyDeclaration {
        let type = this.parseType(doclet);

        let obj = dom.create.property(doclet.name, type);

        this.processGeneric(doclet, obj, null);

        this.processFlags(doclet, obj);

        return obj;
    }

    /**
     * Create a new `Prop` based off a `IDocletProp`.
     *
     * @param {IDocletProp} doclet
     *
     * @return {PropertyDeclaration}
     */
    private createProp(doclet: IDocletProp): dom.PropertyDeclaration {
        let type = this.parseType(doclet);

        let obj = dom.create.property(doclet.name, type);

        this.processFlags(doclet, obj);

        return obj;
    }

    private createEvent(doclet: IEventDoclet): dom.ConstDeclaration {
        // this could all be "somewhat wrong", and subject to change
        // TODO: this should return an "event" function
        let type = dom.type.any;

        let obj = dom.create.const(doclet.name, type);

        this.processFlags(doclet, obj);

        return obj;
    }

    private createEnum(doclet: IMemberDoclet): dom.EnumDeclaration {
        let obj = dom.create.enum(doclet.name, false);

        this.processFlags(doclet, obj);

        return obj;
    }

    private createFunction(doclet: IFunctionDoclet): dom.FunctionDeclaration {
        let returnType: dom.Type = dom.type.void;

        if (doclet.returns) {
            returnType = this.parseType(doclet.returns[0]);
        }

        let obj = dom.create.function(doclet.name, null, returnType);
        this.setParams(doclet, obj);

        this.processGeneric(doclet, obj, obj.parameters);

        this.processFlags(doclet, obj);

        return obj;
    }

    private createTypedef(doclet: ITypedefDoclet): dom.TypeAliasDeclaration {
        const typeName = doclet.type.names[0];
        let type = null;

        // TODO: this doesn't support 'Object', which is typically what should be used.
        if (doclet.type.names[0] === 'object') {
            let properties = [];

            for (let propDoc of doclet.properties) {
                let prop = this.createProp(propDoc);
                properties.push(prop);
                if (propDoc.description)
                    prop.jsDocComment = propDoc.description.replace(regexEndLine, '$1\n');
            }

            type = dom.create.objectType(properties);

            if (doclet.augments && doclet.augments.length) {
                let intersectionTypes = [];
                for (let i = 0; i < doclet.augments.length; i++) {
                    intersectionTypes.push(dom.create.namedTypeReference(doclet.augments[i]));
                }
                intersectionTypes.push(type);
                type = dom.create.intersection(intersectionTypes);
            }

        } else {
            type = dom.create.functionType(null, dom.type.void);
            this.setParams(doclet, type);
        }

        let alias = dom.create.alias(doclet.name, type);

        this.processGeneric(doclet, alias, null);

        return alias;
    }

    private setParams(
        doclet:
            | ITypedefDoclet
            | IFunctionDoclet
            | IClassDoclet,
        obj:
            | dom.FunctionDeclaration
            | dom.ConstructorDeclaration
    ): void {
        let parameters: dom.Parameter[] = [];

        if (doclet.params) {

            let optional = false;

            obj.jsDocComment = '';

            for (let paramDoc of doclet.params) {

                // TODO REMOVE TEMP FIX
                if (paramDoc.name.indexOf('.') != -1) {
                    console.log(`Warning: ignoring param with '.' for '${doclet.longname}' in ${doclet.meta.filename}@${doclet.meta.lineno}`);

                    let defaultVal = paramDoc.defaultvalue !== undefined ? ` Default ${String(paramDoc.defaultvalue)}.` : '';
                    if (paramDoc.description)
                        obj.jsDocComment += `\n@param ${paramDoc.name} ${paramDoc.description.replace(regexEndLine, '$1\n')}` + defaultVal;
                    else if (defaultVal.length)
                        obj.jsDocComment += `\n@param ${paramDoc.name} ` + defaultVal;
                    continue;
                }
                ///////////////////////

                let param = dom.create.parameter(paramDoc.name, this.parseType(paramDoc));
                parameters.push(param);

                if (optional && paramDoc.optional != true) {
                    console.log(`Warning: correcting to optional: parameter '${paramDoc.name}' for '${doclet.longname}' in ${doclet.meta.filename}@${doclet.meta.lineno}`);
                    paramDoc.optional = true;
                }

                this.processFlags(paramDoc, param);

                optional = optional || paramDoc.optional === true;

                let defaultVal = paramDoc.defaultvalue !== undefined ? ` Default ${String(paramDoc.defaultvalue)}.` : '';

                if (paramDoc.description)
                    obj.jsDocComment += `\n@param ${paramDoc.name} ${paramDoc.description.replace(regexEndLine, '$1\n')}` + defaultVal;
                else if (defaultVal.length)
                    obj.jsDocComment += `\n@param ${paramDoc.name} ` + defaultVal;
            }
        }

        obj.parameters = parameters;
    }

    private parseType(
        typeDoc?:
            | IMemberDoclet
            | IDocletProp
            | IDocletReturn
    ): dom.Type {
        if (!typeDoc || !typeDoc.type) {
            return dom.type.any;
        } else {
            let types = [];
            for (let name of typeDoc.type.names) {

                name = this.prepareTypeName(name);

                let type = dom.create.namedTypeReference(this.processTypeName(name));

                types.push(type);
            }
            if (types.length == 1) return types[0];
            else return dom.create.union(types);
        }
    }

    private prepareTypeName(name: string): string {
        if (name.indexOf('*') != -1) {
            name = (<string>name).split('*').join('any');
        }
        if (name.indexOf('.<') != -1) {
            name = (<string>name).split('.<').join('<');
        }
        return name;
    }

    private processTypeName(name: string): string {
        if (name === 'float') return 'number';
        if (name === 'function') return 'Function';
        if (name === 'array') return 'any[]';

        if (name.startsWith('Array<')) {
            let matches = name.match(/^Array<(.*)>$/);

            if (matches && matches[1]) {
                return this.processTypeName(matches[1]) + '[]';
            }
        } else if (name.startsWith('Object<')) {
            let matches = name.match(/^Object<(.*)>$/);

            if (matches && matches[1]) {
                if (matches[1].indexOf(',') != -1) {
                    let parts = matches[1].split(',');
                    return `{[key: ${this.processTypeName(parts[0])}]: ${this.processTypeName(parts[1])}}`;
                } else {
                    return `{[key: string]: ${this.processTypeName(matches[1])}}`;
                }
            }
        }

        return name;
    }

    // region processFlags
    /**
     * Processes the flags on the given `doclet`, ensuring those flags are properly applied to the `domObj`.
     *
     * @todo `@abstract` isn't supported on methods or classes
     * @todo we could check for `description` property here, to build a report of what's missing descriptions
     *
     * @param {Readonly<IDocletProp> | Readonly<TDoclet>} doclet
     * @param {DeclarationBase | Parameter} domObj
     *
     * @instance
     * @private
     */
    private processFlags(
        doclet: Readonly<IDocletProp> | Readonly<TDoclet>,
        domObj: dom.DeclarationBase | dom.Parameter
    ): void {
        domObj.flags = dom.DeclarationFlags.None;

        if (Guard.doclet.isIDocletProp(doclet)) {
            this._processFlagsForPropDoclet(doclet, domObj);
        }

        if (Guard.doclet.isTDoclet(doclet)) {
            this._processFlagsForTDoclet(doclet, domObj);
        }

        if (Guard.doclet.isIMemberDoclet(doclet)) {
            this._processFlagsForIMemberDoclet(doclet, domObj);
        }
    }

    /**
     * Processes the flags for a {@link IMemberDoclet `IMemberDoclet`}-type `doclet`,
     * ensuring those flags are properly applied to the `domObj`.
     *
     * @param {Readonly<IMemberDoclet>} doclet
     * @param {DeclarationBase | Parameter} domObj
     *
     * @instance
     * @private
     */
    private _processFlagsForIMemberDoclet(
        doclet: Readonly<IMemberDoclet>,
        domObj: dom.DeclarationBase | dom.Parameter
    ): void {
        if (doclet.readonly || doclet.kind === 'constant') {
            domObj.flags |= dom.DeclarationFlags.ReadOnly;
        }
    }

    /**
     * Processes the flags for a {@link TDoclet `TDoclet`}-type `doclet`,
     * ensuring those flags are properly applied to the `domObj`.
     *
     * @param {Readonly<TDoclet>} doclet
     * @param {DeclarationBase | Parameter} domObj
     *
     * @instance
     * @private
     */
    private _processFlagsForTDoclet(
        doclet: Readonly<TDoclet>,
        domObj: dom.DeclarationBase | dom.Parameter
    ): void {
        switch (doclet.access) {
            case 'protected':
                domObj.flags |= dom.DeclarationFlags.Protected;
                break;
            case 'private':
                domObj.flags |= dom.DeclarationFlags.Private;
                break;
        }

        if (doclet.scope === 'static') {
            domObj.flags |= dom.DeclarationFlags.Static;
        }
    }

    /**
     * Processes the flags for a {@link IDocletProp `IDocletProp`}-type `doclet`,
     * ensuring those flags are properly applied to the `domObj`.
     *
     * @param {Readonly<IDocletProp>} doclet
     * @param domObj
     *
     * @instance
     * @private
     */
    private _processFlagsForPropDoclet(
        doclet: Readonly<IDocletProp>,
        domObj: dom.DeclarationBase | dom.Parameter
    ): void {
        if (doclet.variable) {
            if (!Guard.dom.isParameter(domObj)) {
                throw new Error('doclet marked as variable doesn\'t have "parameter" kind dom element');
            } // ensures that it's a type that actually has a 'type' property.

            domObj.flags |= dom.ParameterFlags.Rest;

            const type = domObj.type;
            if (!Guard.dom.type.isNamedTypeReference(type) && !Guard.dom.type.isTypeParameter(type)) {
                throw new Error('"variable" doclet dom.Parameter.type isn\'t of the correct kind');
            } // ensures that it's a type that actually has a 'name' property

            /*
                TODO: what if you want a 2+d array?
                    Currently, if you do "...T[]", that'll become "...T[]" in the typings.

                I can't find anywhere in jsdoc about adding `[]` to rest parameters,
                leading me to believe the above should actually become "...T[][]".

                Note this happens even if you use `...Array<T>`, b/c `Array<T>` is
                transformed elsewhere into `...T[]`.

                Ideally, this should be written up as a 'parser rule' somewhere.
             */
            if (!type.name.endsWith('[]')) {
                /*
                    TODO: is this still needed?
                        Types seem to be generated correctly even if not '...*'. maybe it was for object properties?

                    I can't seem to create a jsdoc where this actually has problems.

                    Asked @antriel about it:
                        > I remember there was a reason for that. Just not sure what.
                        > I think the jsdocs then parsed the type wrongly or something.
                        > Ah right. Yes, if you did rest param but the jsdoc was defined as non array, you couldn't put in more stuff... Or something like that.
                 */
                if (type.name != 'any') {
                    // @ts-ignore TODO: IDocletProp doesn't have a longname property - find an alternative
                    console.log(`Warning: rest parameter should be an array type for ${doclet.longname}`);
                }

                type.name += '[]'; // Must be an array
            }

            return;
        } // Rest implies Optional, & it's illegal in TS to mark both.

        if (doclet.optional) {
            domObj.flags |= Guard.dom.isParameter(domObj)
                ? dom.ParameterFlags.Optional
                : dom.DeclarationFlags.Optional;
        }
    }

    // endregion

    private processGeneric(
        doclet: IDocletBase,
        obj:
            | dom.ClassDeclaration
            | dom.FunctionDeclaration
            | dom.PropertyDeclaration
            | dom.TypeAliasDeclaration,
        params: dom.Parameter[]
    ): void {
        if (doclet.tags)
            for (let tag of doclet.tags) {
                if (tag.originalTitle === 'generic') {
                    let matches = tag.value.match(/(?:(?:{)([^}]+)(?:}))?\s?([^\s]+)(?:\s?-\s?(?:\[)(.+)(?:\]))?/);
                    let typeParam = dom.create.typeParameter(matches[2], matches[1] == null ? null : dom.create.typeParameter(matches[1]));

                    if (obj.kind !== 'property') {
                        obj.typeParameters.push(typeParam);
                    }

                    handleOverrides(matches[3], matches[2]);
                } else if (tag.originalTitle === 'genericUse') {
                    let matches = tag.value.match(/(?:(?:{)([^}]+)(?:}))(?:\s?-\s?(?:\[)(.+)(?:\]))?/);
                    let overrideType: string = this.prepareTypeName(matches[1]);

                    handleOverrides(matches[2], this.processTypeName(overrideType));
                }
            }

        function handleOverrides(matchedString: string, overrideType: string) {
            if (matchedString != null) {
                let overrides = matchedString.split(',');
                if (params != null) {
                    for (let param of params) {
                        if (overrides.indexOf(param.name) != -1) {
                            param.type = dom.create.namedTypeReference(overrideType);
                        }
                    }
                }
                if (obj.kind === 'function' && overrides.indexOf('$return') != -1) {// has $return, must be a function
                    obj.returnType = dom.create.namedTypeReference(overrideType);
                }

                if (obj.kind === 'property' && overrides.indexOf('$type') != -1) {// has $type, must be a property
                    obj.type = dom.create.namedTypeReference(overrideType);
                }
            }
        }
    }

}
