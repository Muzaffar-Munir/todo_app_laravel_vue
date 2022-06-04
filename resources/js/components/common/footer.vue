<template>
  <div>
    <!-- footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-6">
            <h3>ABOUT</h3>
            <img src="../../../../public/assets/images/logo-footer.1.png" alt="logo" />
            <p>
             Do you want to know the secret to increasing your business sales without investing more of your valuable time and hard-earned money? <router-link :to="{name:'about-us'}"><span  class="font-weight-bold" style=" color:#5cc9be; ">Learn more...</span></router-link>
            </p>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-3">
            <h3>LEGAL</h3>
            <ul>
              <!-- <router-link :to="{name:'privacy-policy'}"><li class="text-white">Privacy Policy</li></router-link> -->
              <router-link :to="{name:'terms-of-use'}"><li class="text-white">Terms Of Use</li></router-link>
              <!-- <router-link :to="{name:'faqs'}"><li class="text-white">Faq's</li></router-link> -->
            </ul>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-3">
            <h3>SOCIAL MEDIA</h3>
            <ul v-if="!socialLinks || !socialLinks.length">
              <li>Facebook</li>
              <li>Instagram</li>
              <li>Twitter</li>
              <li>LinkedIn</li>
            </ul>
           
            <div class="social_links" v-if="socialLinks && socialLinks.length">
              <ul>
                <li>
                <a :href="facebook_link" target="#">
                    <i class="fa fa-facebook icon"></i>    </a>
                </li>
                <li>
                    <a :href="twitter_link" target="#"><i class="fa fa-twitter icon"></i></a>
                </li>
                <li>
                  <a :href="linkedin_link" target="#"><i class="fa fa-linkedin icon"></i></a>
                </li>
                <li>
                  <a :href="instagram_link" target="#"><i class="fa fa-instagram icon"></i></a>
                </li>
              </ul>
            </div>
              
             
          </div>
        </div>
      </div>
    </footer>
    <div class="copyright">
      <div class="container">
        <div class="row copyright-content">
          <p class="copyright-content-p">All rights reserved @ UpsellUpscale.com 2020</p>
          <p>Powered by <a href="https://www.webonclicks.com.au/" class="link-color" target="#">WebOnClicks</a> </p>
        </div>
      </div>
    </div>

  </div>
</template>
<script>
export default {
  data() {
    return {
      socialLinks: null,
      facebook_link: null,
      twitter_link: null,
      instagram_link: null,
      linkedin_link: null,
    }
  },
  async created() {
    this.socialLinks = (await axios.get('/index.php/api/social_links')).data
    if(this.socialLinks && this.socialLinks.length){
      this.socialLinks.forEach((element) => {
        if(element.type && element.type=='Twitter'){
          this.twitter_link = element.url;
        }
        if(element.type && element.type=='Facebook'){
          this.facebook_link = element.url;
        }
        if(element.type && element.type=='Instagram'){
          this.instagram_link = element.url;
        }
        if(element.type && element.type=='Linkedin'){
          this.linkedin_link = element.url;
        }
        
        });
    }
  },
}
</script>
<style scoped>
.link-color{
  color: white;
  text-decoration: underline;
}
/* starting social css */
.social_links ul {
  display: flex;
  position: absolute;
  top: 50%;
  left: 25%;
  transform: translate(-50%, -50%);
}

.social_links ul li {
  list-style: none;
}

.social_links ul li a {
  width: 35px;
  height: 35px;
  background-color: #fff;
  text-align: center;
  line-height: 35px;
  font-size: 20px;
  margin: 0 5px;
  display: block;
  border-radius: 50%;
  position: relative;
  overflow: hidden;
  border: 1.5px solid #fff;
  z-index: 1;
}

.social_links ul li a .icon {
  position: relative;
  color: #262626;
  transition: .5s;
  z-index: 3;
}

.social_links ul li a:hover .icon {
  color: #fff;
  transform: rotateY(360deg);
}

.social_links ul li a:before {
  content: "";
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  height: 100%;
  background: #f00;
  transition: .5s;
  z-index: 2;
}

.social_links ul li a:hover:before {
  top: 0;
}

.social_links ul li:nth-child(1) a:before{
  background: #3b5999;
}

.social_links ul li:nth-child(2) a:before{
  background: #55acee;
}

.social_links ul li:nth-child(3) a:before {
  background: #0077b5;
}

.social_links ul li:nth-child(4) a:before {
  background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
}
/* ending social css */
</style>