const GetMarkDownLink = (text = '') => {

    const pattern = /\[[ 0-9a-z.#\(\)_]{0,}\]{@link[ 0-9a-z.\(\):#\/\/_]{0,}}|{@link[ 0-9a-z.\(\):#\/\/\|_]{0,}}/gi;
    const pattern_url = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/\/=]*)/gi;
    
    let link_markdown = (text !== undefined) ? text.replace(pattern, (string) => {
        let link_result = '';
        if (string.match(/\[[a-zA-Z\(\)_\/\/]{0,}\]/i)) {
            link = string.replace('}', ')')
                .replace('{@link', '(')
                .replace('( ', '(');

            if (link.indexOf('(code ') != -1) {
                link_result = link.replace('(code ', '(').replace('[', '[``').replace(']', '``]');
            } else {
                link_result = link;
            }    
        } else {
            const array_with_description = string.split('|');
            const array_whit_space_description = string.split(' ');

            if (array_with_description.length > 1) {
                const description = '[' + array_with_description[1].replace('}', ']');
                const clean_link = array_with_description[0]
                    .replace('{@link', '(')
                    .replace('( ', '(') + ')';
                link_result = description + clean_link;
            } else {
                let link = '';
                let tag = '';

                // Links like this: {@link Phaser.Physics.Arcade.Body init()}
                if(array_whit_space_description.length > 2) {
                    const separate = string.split('{@link').filter((obj) => (obj !== ''))[0];
                    clean_elements = separate.trim().replace('}', '');

                    link = clean_elements.split(" ")[1];
                    tag = clean_elements.split(" ")[0];

                } else {
                    const separate = string.split('{@link').filter((obj) => (obj !== ''))[0];
                    link = separate.trim().replace('}', '');
                    tag = link;
                }

                link_result = `[${link}](${tag})`;
            }
        }
        return link_result;
    }) : '';


    link_markdown = (link_markdown !== '') ? link_markdown.replace(pattern_url, (string) => {
        return ((/[\w:\\\\\/\/.]{0,}\)/gi).test(string)) ? string : `[${string}](${string})`;
    }) : '';

    return link_markdown;
}

module.exports = GetMarkDownLink;