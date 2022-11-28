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
          <SocialNetworkButton Image="Facebook_logo.png" onClick={() => {this.props.onClick3(); this.handleToggleButton('Facebook');}} Active={this.state.currNetwork == 'Facebook'}/>
          <SocialNetworkButton Image="Instagram_logo.png" onClick={() => {this.props.onClick4(); this.handleToggleButton('Instagram');}} Active={this.state.currNetwork == 'Instagram'}/>
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
      onClick3={() => this.setNetwork('Facebook')}
      onClick4={() => this.setNetwork('Instagram')}
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

    addFav() {
      var session;
      Jquery.ajaxSetup({cache: false})
      Jquery.ajax({
        url: 'PHP/getsession.php',
        success: function (data) {
          session = data;
        },
        async: false
      });
      var sessionObj = JSON.parse(session);


      jQuery.ajax({
        url:"PHP/ajout_suppr_utilisateurs.php",
        type:"post",
        dataType:"json",
        data: {action: "ADD", dbName: "utilisateurs", idUser: sessionObj.id, idInfluencer: ""}

    });
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
      <button className="boutonFavoris"><img src="favourite.png" width="50px"></img></button>
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
  

  export {SocialNetworkPage, YoutuberInfo}