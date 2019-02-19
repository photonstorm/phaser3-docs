import * as dom from 'dts-dom';

export default class Guard {
    /**
     * Guards for types from `jsdoc` doclets.
     */
    static doclet = class {
        /**
         * Guards that the given `doclet` is of type `TDoclet`.
         *
         * @param {Object} doclet
         *
         * @return {doclet is TDoclet}
         */
        static isTDoclet(doclet: object): doclet is TDoclet {
            return typeof doclet === 'object' && 'kind' in doclet;
        }

        /**
         * Guards that the given `doclet` is of type `IDocletProp`.
         *
         * @param {any | IDocletProp} doclet
         *
         * @return {doclet is IDocletProp}
         */
        static isIDocletProp(doclet: any | IDocletProp): doclet is IDocletProp {
            return typeof doclet === 'object'
                   && 'type' in doclet
                   && 'name' in doclet
                   && typeof doclet.type === 'object';
        }

        /**
         * Guards that the given `doclet` is of type `IMemberDoclet`.
         *
         * @param {any | TDoclet} doclet
         *
         * @return {doclet is IMemberDoclet}
         */
        static isIMemberDoclet(doclet: object | TDoclet): doclet is IMemberDoclet {
            return typeof doclet === 'object'
                   && 'kind' in doclet
                   && (doclet.kind === 'constant' || doclet.kind === 'member');
        }
    };

    /**
     * Guards for types from `dts-dom`.
     */
    static dom = class {
        /**
         * Guards for `Type`s.
         */
        static type = class {
            /**
             * Guards that the given `type` is of type `dom.NamedTypeReference`.
             *
             * @param {any | Type} type
             *
             * @return {type is NamedTypeReference}
             */
            static isNamedTypeReference(type: dom.Type): type is dom.NamedTypeReference {
                return typeof type === 'object' && type.kind === 'name';
            }

            /**
             * Guards that the given `type` is of type `dom.TypeParameter`.
             *
             * @param {any | Type} type
             *
             * @return {type is TypeParameter}
             */
            static isTypeParameter(type: dom.Type): type is dom.TypeParameter {
                return typeof type === 'object' && type.kind === 'type-parameter';
            }
        };

        /**
         * Guards that the given `element` is of type `dom.Parameter`.
         *
         * @param {any | Parameter} element
         *
         * @return {element is Parameter}
         */
        static isParameter(element: any | dom.Parameter): element is dom.Parameter {
            return element.kind === 'parameter';
        }
    };
}
