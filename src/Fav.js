import React from "react";
import Jquery from "jquery"
import { influenceurs } from "./SearchBar.js";





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

    getFav() {
        influenceurs =[];
        var session;
        Jquery.ajaxSetup({cache: false})
        Jquery.ajax({
            url: "PHP/trouver_mes_favoris.php",
        })


        Jquery.ajax({
          url: 'PHP/getsession.php',
          success: function (data) {
            session = data;
          },
          async: false
        });
        var sessionObj = JSON.parse(session);
        console.log(sessionObj.Fav);
        var data2=sessionObj.Fav.split(',');
        var arr=JSON.parse(data2);
        console.log(arr);
        arr.forEach(e=>influenceurs.push([e.username,e.nb_views,e.nb_subscribers,e.nb_videos,e.image,e.url]));
        return arr;
        
    }

    
    render(){

        let listFavoris = this.getFav();

        return(<>
            {listFavoris.map(i=>
            <FavorisInfos Name={i.username} Follower={i.nb_subscribers} NombreVideos={i.nb_videos} NombreVues={i.nb_views} Link={i.url} Image={i.image}/>
            )
            }
            <button onClick={() => {alert(this.getFav())}}></button>
        </>)
    }
}



export default FavPage;