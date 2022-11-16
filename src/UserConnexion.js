
import React from "react";



function LogButton(props){
    return <a className='logButton' href={props.Link}>{props.Page}</a>;
}

export default LogButton