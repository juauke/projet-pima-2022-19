import React from "react";
import {YoutuberInfo}  from "./SocialNetworkMenu.js";



class FavorisInfos extends React.Component {
    constructor(props) {
      super(props)
    }
  
    render() {
      return(<>
      <div className='influenceurWrap'>
      <h3 className='influenceurName'>{this.props.Name}</h3>
      <img src={this.props.Image} className="influenceurImage"></img>
      <p className='influenceurFollower'>Nombre de followers : <br/>{this.props.Follower}</p>
      <p className='influenceurVids'>Nombre de vidéos publiées : {this.props.NombreVideos}</p>
      <p className='influenceurVues'>Nombre de vues : <br/>{this.props.NombreVues}</p>
      <a className='influenceurLink' href={this.props.Link}>{this.props.Link}</a>
      </div>
      </>);
    }
  }

class FavPage extends React.Component {
    constructor(props) {
        super(props);
    }



    
    render(){

        let listFavoris = [["Test1", "Test2", "Test3", "Test4", "Test5"],["Test11", "Test22", "Test33", "Test44", "Test55"]]

        return(<>
            {listFavoris.map(i=>
            <FavorisInfos Name={i[0]} Follower={i[1]} NombreVideos={i[2]} NombreVues={i[3]} Link={i[4]} />
            )
            }
        </>)
    }
}



export default FavPage;