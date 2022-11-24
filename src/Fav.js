import React from "react";
import {YoutuberInfo}  from "./SocialNetworkMenu.js";

class FavPage extends React.Component {
    constructor(props) {
        super(props);
    }


    render(){

        let listFavoris = [["Test1", "Test2", "Test3", "Test4", "Test5"],["Test11", "Test22", "Test33", "Test44", "Test55"]]

        return(<>
            {listFavoris.map(i=>
            <YoutuberInfo Name={i[0]} Follower={i[1]} NombreVideos={i[2]} NombreVues={i[3]} Link={i[4]} />
            )
            }
        </>)
    }
}


export default FavPage;