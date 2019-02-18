import * as dom from 'dts-dom';

export default class Guard {
    /**
     * Guards for types from `jsdoc` doclets.
     */
    static doclet = class {
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
                   && 'description' in doclet
                   && 'comment' in doclet
                   && typeof doclet.type === 'object';
        }
    };

    /**
     * Guards for types from `dts-dom`.
     */
    static dom = class {
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
