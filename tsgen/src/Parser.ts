import * as dom from 'dts-dom';
import Guard from './Guard';

const regexEndLine = /^(.*)\r\n|\n|\r/gm;

export class Parser {

    topLevel: dom.TopLevelDeclaration[];
    objects: { [key: string]: dom.DeclarationBase };
    namespaces: { [key: string]: dom.NamespaceDeclaration };

    constructor(doclets: Array<TDoclet>) {
        // TODO remove once stable
        for (let i = 0; i < doclets.length; i++) {
            const doclet = doclets[i];

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
        this._parseDoclets(doclets);

        this._resolveDoclets(doclets);

        // removes members inherited from classes
        // possibly could be avoided if mixins were defined as such before JSDoc parses them and then we could globally remove all inherited (not
        // overriden) members globally from the parsed DB
        this._resolveInheritance(doclets);

        this._resolveParents(doclets);

        // add integer alias
        this.topLevel.push(dom.create.alias('integer', dom.type.number));

        // add declare module
        const phaserPkgModuleDOM = dom.create.module('phaser');
        phaserPkgModuleDOM.members.push(dom.create.exportEquals('Phaser'));
        this.topLevel.push(phaserPkgModuleDOM);
    }

    emit() {
        const ignored = [];
        const result = this.topLevel.reduce((out: string, obj: dom.TopLevelDeclaration) => {
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

    private _parseDoclets(doclets: Array<TDoclet>): void {
        for (let i = 0; i < doclets.length; i++) {
            const doclet = doclets[i];

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
                    obj = this._createNamespaceDeclaration(doclet);
                    container = this.namespaces;
                    break;
                case 'class':
                    obj = this._createClassDeclaration(doclet);
                    break;
                case 'mixin':
                    obj = this._createInterfaceDeclaration(doclet);
                    break;
                case 'member':
                    if (doclet.isEnum === true) {
                        obj = this._createEnumDeclaration(doclet);
                        break;
                    }
                case 'constant':
                    obj = this._createMemberDeclaration(doclet);
                    break;
                case 'function':
                    obj = this._createFunctionDeclaration(doclet);
                    break;
                case 'typedef':
                    obj = this._createTypedefDeclaration(doclet);
                    break;
                case 'event':
                    obj = this._createEventDeclaration(doclet);
                    break;
                default:
                    console.log('Ignored doclet kind: ' + doclet.kind);
                    break;
            }

            if (obj) {
                if (container[doclet.longname]) {
                    console.log('Warning: ignoring duplicate doc name: ' + doclet.longname);
                    doclets.splice(i--, 1);
                    continue;
                }
                container[doclet.longname] = obj;
                if (doclet.description) {
                    const otherDocs = obj.jsDocComment || '';
                    obj.jsDocComment = doclet.description.replace(regexEndLine, '$1\n') + otherDocs;
                }
            }
        }
    }

    private _resolveDoclets(doclets: Array<TDoclet>): void {
        const allTypes = new Set<string>();
        for (const doclet of doclets) {
            const obj = doclet.kind === 'namespace' ? this.namespaces[doclet.longname] : this.objects[doclet.longname];

            if (!obj) {

                //  TODO
                console.log(`Warning: Didn't find object for ${doclet.longname}`);

                continue;
            }

            if (!doclet.memberof) {
                this.topLevel.push(obj as dom.TopLevelDeclaration);
            } else {
                const isNamespaceMember = doclet.kind === 'class' || doclet.kind === 'typedef' || doclet.kind == 'namespace' || ('isEnum' in doclet && doclet.isEnum);
                let parent = isNamespaceMember ? this.namespaces[doclet.memberof] : (this.objects[doclet.memberof] || this.namespaces[doclet.memberof]);

                //TODO: this whole section should be removed once stable
                if (!parent) {
                    console.log(`${doclet.longname} in ${doclet.meta.filename}@${doclet.meta.lineno} has parent '${doclet.memberof}' that is not defined.`);
                    const parts: string[] = doclet.memberof.split('.');
                    const newParts = [parts.pop()];
                    while (parts.length > 0 && this.objects[parts.join('.')] == null) newParts.unshift(parts.pop());
                    parent = this.objects[parts.join('.')] as dom.NamespaceDeclaration;
                    if (parent == null) {
                        parent = dom.create.namespace(doclet.memberof);
                        this.namespaces[doclet.memberof] = <dom.NamespaceDeclaration>parent;
                        this.topLevel.push(<dom.NamespaceDeclaration>parent);
                    } else {
                        while (newParts.length > 0) {
                            const oldParent = <dom.NamespaceDeclaration>parent;
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

    private _resolveInheritance(doclets: Array<TDoclet>): void {
        for (const doclet of doclets) {
            const obj = doclet.kind === 'namespace' ? this.namespaces[doclet.longname] : this.objects[doclet.longname];
            if (!obj) {

                //  TODO
                console.log(`Didn't find type ${doclet.longname} ???`);

                continue;
            }
            if (!(<any>obj)._parent) continue;

            if (doclet.inherited) {// remove inherited members if they aren't from an interface
                const from = this.objects[doclet.inherits];
                if (!from || !(<any>from)._parent)
                    throw `'${doclet.longname}' should inherit from '${doclet.inherits}', which is not defined.`;

                if ((<any>from)._parent.kind != 'interface') {
                    (<any>obj)._parent.members.splice((<any>obj)._parent.members.indexOf(obj), 1);
                    (<any>obj)._parent = null;
                }
            }
        }
    }

    private _resolveParents(doclets: Array<TDoclet>): void {
        for (const doclet of doclets) {
            const obj = this.objects[doclet.longname];
            if (!obj || doclet.kind !== 'class') continue;

            const o = obj as dom.ClassDeclaration;

            // resolve augments
            if (doclet.augments && doclet.augments.length) {
                for (const augment of doclet.augments) {
                    const name: string = this._prepareTypeName(augment);

                    const wrappingName = name.match(/[^<]+/s)[0];//gets everything up to a first < (to handle augments with type parameters)

                    const baseType = this.objects[wrappingName] as dom.ClassDeclaration | dom.InterfaceDeclaration;

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

    private _createNamespaceDeclaration(doclet: INamespaceDoclet): dom.NamespaceDeclaration {

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

        const obj = dom.create.namespace(doclet.name);

        return obj;
    }

    private _createClassDeclaration(doclet: IClassDoclet): dom.ClassDeclaration {
        const obj = dom.create.class(doclet.name);

        let params = null;
        if (doclet.params) {
            const ctor = dom.create.constructor(null);
            this._parseFunctionParameters(doclet, ctor);
            params = ctor.parameters;

            obj.members.push(ctor);
            (<any>ctor)._parent = obj;
        }

        this._processGeneric(doclet, obj, params);

        if (doclet.classdesc)
            doclet.description = doclet.classdesc.replace(regexEndLine, '$1\n'); // make sure docs will be added

        return obj;
    }

    private _createInterfaceDeclaration(doclet: IClassDoclet): dom.InterfaceDeclaration {
        return dom.create.interface(doclet.name);
    }

    private _createMemberDeclaration(doclet: IMemberDoclet): dom.PropertyDeclaration {
        const type = this._determineDOMType(doclet);

        const obj = dom.create.property(doclet.name, type);

        this._processGeneric(doclet, obj, null);
        this._processFlags(doclet, obj);

        return obj;
    }

    /**
     * Create a new `Prop` based off a `IDocletProp`.
     *
     * @param {IDocletProp} doclet
     *
     * @return {PropertyDeclaration}
     */
    private _createPropertyDeclaration(doclet: IDocletProp): dom.PropertyDeclaration {
        const type = this._determineDOMType(doclet);

        const obj = dom.create.property(doclet.name, type);

        this._processFlags(doclet, obj);

        return obj;
    }

    private _createEventDeclaration(doclet: IEventDoclet): dom.ConstDeclaration {
        // this could all be "somewhat wrong", and subject to change
        // TODO: this should return an "event" function
        const type = dom.type.any;

        const obj = dom.create.const(doclet.name, type);

        this._processFlags(doclet, obj);

        return obj;
    }

    private _createEnumDeclaration(doclet: IMemberDoclet): dom.EnumDeclaration {
        const obj = dom.create.enum(doclet.name, false);

        this._processFlags(doclet, obj);

        return obj;
    }

    private _createFunctionDeclaration(doclet: IFunctionDoclet): dom.FunctionDeclaration {
        const returnType: dom.Type = doclet.returns
            ? this._determineDOMType(doclet.returns[0])
            : dom.type.void;

        const obj = dom.create.function(doclet.name, null, returnType);

        this._parseFunctionParameters(doclet, obj);

        this._processGeneric(doclet, obj, obj.parameters);
        this._processFlags(doclet, obj);

        return obj;
    }

    private _createTypedefDeclaration(doclet: ITypedefDoclet): dom.TypeAliasDeclaration {
        const typeName = doclet.type.names[0];
        let type = null;

        // TODO: this doesn't support 'Object', which is typically what should be used.
        if (doclet.type.names[0] === 'object') {
            const properties = [];

            for (const propDoc of doclet.properties) {
                const prop = this._createPropertyDeclaration(propDoc);
                properties.push(prop);
                if (propDoc.description)
                    prop.jsDocComment = propDoc.description.replace(regexEndLine, '$1\n');
            }

            type = dom.create.objectType(properties);

            if (doclet.augments && doclet.augments.length) {
                const intersectionTypes = [];
                for (let i = 0; i < doclet.augments.length; i++) {
                    intersectionTypes.push(dom.create.namedTypeReference(doclet.augments[i]));
                }
                intersectionTypes.push(type);
                type = dom.create.intersection(intersectionTypes);
            }

        } else {
            type = dom.create.functionType(null, dom.type.void);
            this._parseFunctionParameters(doclet, type);
        }

        const alias = dom.create.alias(doclet.name, type);

        this._processGeneric(doclet, alias, null);

        return alias;
    }

    private _parseFunctionParameters(
        doclet:
            | ITypedefDoclet
            | IFunctionDoclet
            | IClassDoclet,
        obj:
            | dom.FunctionDeclaration
            | dom.ConstructorDeclaration
    ): void {
        const parameters: dom.Parameter[] = [];

        if (doclet.params) {

            let optional = false;

            obj.jsDocComment = '';

            for (const paramDoc of doclet.params) {

                // TODO REMOVE TEMP FIX
                if (paramDoc.name.indexOf('.') != -1) {
                    console.log(`Warning: ignoring param with '.' for '${doclet.longname}' in ${doclet.meta.filename}@${doclet.meta.lineno}`);

                    const defaultVal = paramDoc.defaultvalue !== undefined ? ` Default ${String(paramDoc.defaultvalue)}.` : '';
                    if (paramDoc.description)
                        obj.jsDocComment += `\n@param ${paramDoc.name} ${paramDoc.description.replace(regexEndLine, '$1\n')}` + defaultVal;
                    else if (defaultVal.length)
                        obj.jsDocComment += `\n@param ${paramDoc.name} ` + defaultVal;
                    continue;
                }
                ///////////////////////

                const param = dom.create.parameter(paramDoc.name, this._determineDOMType(paramDoc));
                parameters.push(param);

                if (optional && paramDoc.optional != true) {
                    console.log(`Warning: correcting to optional: parameter '${paramDoc.name}' for '${doclet.longname}' in ${doclet.meta.filename}@${doclet.meta.lineno}`);
                    paramDoc.optional = true;
                }

                this._processFlags(paramDoc, param);

                optional = optional || paramDoc.optional === true;

                const defaultVal = paramDoc.defaultvalue !== undefined ? ` Default ${String(paramDoc.defaultvalue)}.` : '';

                if (paramDoc.description)
                    obj.jsDocComment += `\n@param ${paramDoc.name} ${paramDoc.description.replace(regexEndLine, '$1\n')}` + defaultVal;
                else if (defaultVal.length)
                    obj.jsDocComment += `\n@param ${paramDoc.name} ` + defaultVal;
            }
        }

        obj.parameters = parameters;
    }

    /**
     * Determines the `TypeScript` CodeDOM `Type` to use for the given `doclet`.
     *
     * @param {IMemberDoclet | IDocletProp | IDocletReturn} doclet
     *
     * @return {Type}
     * @private
     */
    private _determineDOMType(
        doclet:
            | Readonly<IMemberDoclet>
            | Readonly<IDocletProp>
            | Readonly<IDocletReturn>
    ): dom.Type {
        if (!doclet.type) {
            return dom.type.any;
        }

        const types = doclet.type.names
                            .map(name => this._prepareTypeName(name))
                            .map(name => this._processTypeName(name))
                            .map(dom.create.namedTypeReference);

        if (types.length === 1) {
            return types[0];
        }

        return dom.create.union(types);
    }

    /**
     * Prepares the `name` of a type so that it can be used to create a {@link NamedTypeReference}.
     *
     * Preparing involves replacing '*' with 'any', and removing '.' from generics.
     *
     * The return of this method is expected to be used with the {@link create#namedTypeReference} method.
     *
     * @examples
     *  "*" => "any"
     *  "Array.<*>" => "Array<any>"
     *  "Array.<string>" => "Array<string>"
     *  "Object.<string, *>" => "Object<string, any>"
     *  "Array.<Array.<integer>>" => "Array<Array<integer>>"
     *  "Array.<Array.<Phaser.Tilemaps.Tile>>" => "Array<Array<Phaser.Tilemaps.Tile>>"
     *  "Phaser.Structs.Set.<T>" => "Phaser.Structs.Set<T>"
     *  "Phaser.Structs.Map.<K, V>" => "Phaser.Structs.Map<K, V>"
     *
     * @param {string} name
     *
     * @return {string}
     * @private
     *
     * @instance
     */
    private _prepareTypeName(name: string): string {
        return name
            .replace(/\*/g, 'any')
            .replace(/\.</g, '<');
    }

    private _processTypeName(name: string): string {
        if (name === 'float') return 'number';
        if (name === 'function') return 'Function';
        if (name === 'array') return 'any[]';

        if (name.startsWith('Array<')) {
            const matches = name.match(/^Array<(.*)>$/);

            if (matches && matches[1]) {
                return this._processTypeName(matches[1]) + '[]';
            }
        } else if (name.startsWith('Object<')) {
            const matches = name.match(/^Object<(.*)>$/);

            if (matches && matches[1]) {
                if (matches[1].indexOf(',') != -1) {
                    const parts = matches[1].split(',');
                    return `{[key: ${this._processTypeName(parts[0])}]: ${this._processTypeName(parts[1])}}`;
                } else {
                    return `{[key: string]: ${this._processTypeName(matches[1])}}`;
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
    private _processFlags(
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

    private _processGeneric(
        doclet: IDocletBase,
        declaration:
            | dom.ClassDeclaration
            | dom.FunctionDeclaration
            | dom.PropertyDeclaration
            | dom.TypeAliasDeclaration,
        parameters: dom.Parameter[]
    ): void {
        if (doclet.tags)
            for (const tag of doclet.tags) {
                if (tag.originalTitle === 'generic') {
                    const matches = tag.value.match(/(?:(?:{)([^}]+)(?:}))?\s?([^\s]+)(?:\s?-\s?(?:\[)(.+)(?:\]))?/);
                    const typeParam = dom.create.typeParameter(matches[2], matches[1] == null ? null : dom.create.typeParameter(matches[1]));

                    if (declaration.kind !== 'property') {
                        declaration.typeParameters.push(typeParam);
                    }

                    handleOverrides(matches[3], matches[2]);
                } else if (tag.originalTitle === 'genericUse') {
                    const matches = tag.value.match(/(?:(?:{)([^}]+)(?:}))(?:\s?-\s?(?:\[)(.+)(?:\]))?/);
                    const overrideType: string = this._prepareTypeName(matches[1]);

                    handleOverrides(matches[2], this._processTypeName(overrideType));
                }
            }

        function handleOverrides(matchedString: string, overrideType: string) {
            if (matchedString != null) {
                const overrides = matchedString.split(',');
                if (parameters != null) {
                    for (const parameter of parameters) {
                        if (overrides.indexOf(parameter.name) != -1) {
                            parameter.type = dom.create.namedTypeReference(overrideType);
                        }
                    }
                }
                if (declaration.kind === 'function' && overrides.indexOf('$return') != -1) {// has $return, must be a function
                    declaration.returnType = dom.create.namedTypeReference(overrideType);
                }

                if (declaration.kind === 'property' && overrides.indexOf('$type') != -1) {// has $type, must be a property
                    declaration.type = dom.create.namedTypeReference(overrideType);
                }
            }
        }
    }

}
