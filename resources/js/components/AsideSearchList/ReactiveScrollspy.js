import React from 'react';
const ReactiveScrollSpy = (props) => {
    console.log(props.reference)
    return <React.Fragment>
        {props.children}
    </React.Fragment>
}

export {ReactiveScrollSpy};
