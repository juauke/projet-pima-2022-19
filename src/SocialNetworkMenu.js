import React from "react";
import Jquery from "jquery"


class SocialNetworkMenu extends React.Component {
    constructor(props) {
      super(props);
      this.state = {currNetwork : 'Youtube'}
    }
  
    handleToggleButton(newNetwork) {
      this.setState({currNetwork : newNetwork});
    }
  
    render() {
      return(
      <>
        <div className='socialNetworkMenu'>
          <SocialNetworkButton Image="Youtube_logo.png" onClick={() => {this.props.onClick1(); this.handleToggleButton('Youtube');}} Active={this.state.currNetwork == 'Youtube'}/>
          <SocialNetworkButton Image="Twitch_logo.png" onClick={() => {this.props.onClick2(); this.handleToggleButton('Twitch');}} Active={this.state.currNetwork == 'Twitch'}/>
          <SocialNetworkButton Image="Spotify_logo.png" onClick={() => {this.props.onClick3(); this.handleToggleButton('Spotify');}} Active={this.state.currNetwork == 'Spotify'}/>

        </div>
      </>
      );
    }
  
  }
  
  
  
  /**
   * 
   */
  class SocialNetworkButton extends React.Component {
    constructor(props) {
      super(props);
    }
  
    render() {
      return (
        <img src={this.props.Image} className={this.props.Active ? " activeButton" : "socialNetworkButton "} onClick={this.props.onClick}></img>
      );
    }
  }
  

  class SocialNetworkPage extends React.Component {
    constructor(props) {
      super(props);
      this.state = { network : 'Youtube'}
    }
  
  setNetwork(newNetwork)
  {
    this.setState({network : newNetwork})
  }
  
    render() {
      return(<>
      <SocialNetworkMenu 
      onClick1={() => this.setNetwork('Youtube')} 
      onClick2={() => this.setNetwork( 'Twitch')}
      onClick3={() => this.setNetwork('Spotify')}
      />
      <SocialNetworkContent Network={this.state.network}/>
      </>)
    }
  }

  class SocialNetworkContent extends React.Component {
    constructor(props) {
      super(props);
    }
  
    render() {
      if(this.props.Network == 'Youtube')
      {
      return(<>
      <YoutubeNetworkContent/>
      
      </>);
      }
      
      else if (this.props.Network == 'Twitch')
      {
        return(<>
        <TwitchNetworkContent/>
        </>)
      }

      else if (this.props.Network == 'Spotify')
      {
        return(<>
        <SpotifyNetworkContent/>
        </>)
      }

      else {
        return(<>
      <h1 className='networkTitle'>{this.props.Network}</h1>
        
        </>); 
      }
    }
  
  }
  
  class YoutuberInfo extends React.Component {
    constructor(props) {
      super(props)
    }

    addFav(nom,nbfollower,nbvideos,nbvues,lien,img,reseau) {
      var session;
      //Jquery.ajaxSetup({cache: false})
      Jquery.ajax({
        url: './PHP/getsession.php',
        success: function (data) {
          session = data;
        },
        async: false
      });
      var sessionObj = JSON.parse(session);
      //console.log(sessionObj.length);
      if(sessionObj.length==0){
        alert("Vous devez être connecté pour ajouter des favoris.")
      }
      else{
      //console.log(nom);
      Jquery.ajax({
        url:"./PHP/ajout_suppr_utilisateurs.php",
        method:"POST",
        async:false,
        data: {"action": "ADD", "dbName": "utilisateurs", "idUser": sessionObj.id,"nom":nom,"nbfollower":nbfollower,"nbvideos" :nbvideos, "nbvues":nbvues,"lien":lien,"img":img,'SocialN':reseau},
        success: function (data) {
          //console.log(data);
        }
    });
    }}

  
    render() {
      return(<>
      <div className='influenceurWrap'>
      <h3 className='influenceurName'>{this.props.Name}</h3>
      <img src={this.props.Image} className="influenceurImage"></img>
      <p className='influenceurFollower'>Nombre de followers : <br/>{this.props.Follower}</p>
      <p className='influenceurVids'>Nombre de vidéos publiées : {this.props.NombreVideos}</p>
      <p className='influenceurVues'>Nombre de vues : <br/>{this.props.NombreVues}</p>
      <a className='influenceurLink' href={this.props.Link}>{this.props.Link}</a>
      <button className="boutonFavoris" onClick={()=>this.addFav(this.props.Name,this.props.Follower,this.props.NombreVideos,this.props.NombreVues,this.props.Link,this.props.Image,this.props.Reseau)}><img src="favourite.png" width="25px"></img></button>
      </div>
      </>);
    }
  }
  
  
  
  
  class YoutubeNetworkContent extends React.Component {
    constructor(props) {
      super(props);
    }
  
    render() {
      return(
      <>
        <h1 className='networkTitle'>Youtube</h1>
        <div className='influenceursDisplayer'>
        <YoutuberInfo Name="Joueur Du Grenier" Image="JDG_pic.jpg" Follower="3,72 M" NombreVideos="150" NombreVues="1 025 230 900 vues" Link="https://www.youtube.com/user/joueurdugrenier" />
        <YoutuberInfo Name="MrBeast" Image="MrBeast_pic.jpg" Follower="107 M" NombreVideos="206" NombreVues="17 812 188 155 vues" Link="https://www.youtube.com/user/MrBeast6000" />
        <YoutuberInfo Name="Nexus VI" Image="NexusVI_pic.jpg" Follower="242 k" NombreVideos="206" NombreVues="18 805 698 vues" Link="https://www.youtube.com/c/ChroniqueNEXUSVI" />
        <YoutuberInfo Name="PewDiePie" Image="PewDiePie_pic.jpg" Follower="111 M" NombreVideos="4 512" NombreVues="28 564 319 008 vues" Link="https://www.youtube.com/user/PewDiePie" />
        </div>
      </>);
    }
  
  }

  class TwitchNetworkContent extends React.Component {
    constructor(props) {
      super(props);
    }
  
    render() {
      return(
      <>
        <h1 className='networkTitle'>Twitch</h1>
        <div className='influenceursDisplayer'>
        <YoutuberInfo Name="Xqc" Image="Xqc_pic.jpeg" Follower="11,4 M" NombreVideos="150" NombreVues="1 025 230 900 vues" Link="https://www.youtube.com/user/joueurdugrenier" />
        <YoutuberInfo Name="Zerator" Image="Zerator_pic.png" Follower="1,5 M" NombreVideos="" NombreVues="" Link="https://www.twitch.tv/zerator" />
        <YoutuberInfo Name="TraytonLol" Image="TraytonLol_pic.png" Follower="150 k" NombreVideos="" NombreVues="" Link="https://www.twitch.tv/traytonlol" />
        <YoutuberInfo Name="JeanMassiet" Image="JeanMassiet_pic.png" Follower="185,9 k" NombreVideos="" NombreVues="" Link="https://www.twitch.tv/jeanmassiet" />
        </div>
      </>);
    }
  
  }

  class SpotifyNetworkContent extends React.Component {
    constructor(props) {
      super(props);
    }
  
    render() {
      return(
      <>
        <h1 className='networkTitle'>Spotify</h1>
        <div className='influenceursDisplayer'>
        <YoutuberInfo Name="Drake" Image="https://i.scdn.co/image/ab6761610000e5eb4293385d324db8558179afd9" Follower="55976173" NombreVideos="84" NombreVues="71102707" Link="https://open.spotify.com/artist/3TVXtAsR1Inumwj472S9r4" />
        <YoutuberInfo Name="Dua Lipa" Image="https://i.scdn.co/image/ab6761610000e5ebd42a27db3286b58553da8858" Follower="37346450" NombreVideos="58" NombreVues="58662647" Link="https://open.spotify.com/artist/6M2wZ9GZgrQXHCFfjv46we" />
        <YoutuberInfo Name=" Niska" Image="https://i.scdn.co/image/ab6761610000e5eb536e207c626c48b3c2419212" Follower="3981812" NombreVideos="14" NombreVues="5023430" Link="https://open.spotify.com/artist/7CUFPNi1TU8RowpnFRSsZV" />
        </div>
      </>);
    }
  
  }
  

  export {SocialNetworkPage, YoutuberInfo}