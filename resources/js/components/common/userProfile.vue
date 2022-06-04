<template>
  <div>
    <div v-if="!userObj">
      <div class="spinner"></div>
    </div>
    <!-- section-top-->
    <section class="create-account-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h3>Freelancer Profile</h3>
          </div>
        </div>
      </div>
    </section>

    <section class="manage-ads">
      <div class="container">
        <div class="row">
          <div class="col-md-12 px-0">
            <div class="new-btn">
              <router-link :to="{name:'listFreelancers'}">
                <button class="back">BACK</button>
              </router-link>
              <h5></h5>
            </div>
          </div>
        </div>

        <div class="row view-ads view-profile" v-if="userObj">
          <div class="col-md-6">
            <img
              :src=" userObj.user && userObj.user.profile_picture ? '/images/users/'+userObj.user.profile_picture :'/images/avatar.png'"
            />
          </div>
          <div class="col-md-6">
            <div class="image-content profile-content">
              <p
                class="name"
              >{{userObj.user.first_name ? userObj.user.first_name : ''}} {{userObj.user.last_name ? userObj.user.last_name : ''}}</p>
              <p class="work">{{userObj.freelancer.industries && userObj.freelancer.industries.title ? userObj.freelancer.industries.title : ''}}</p>

              <!-- rating stars -->
              <!-- <div class="star-setting profile-star">
                <fieldset class="rating profile-rating">
                  <input type="radio" id="star5" name="rating" value="5" />
                  <label class="full" for="star5" title="Awesome - 5 stars"></label>
                  <input type="radio" id="star4half" name="rating" value="4 and a half" />
                  <label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                  <input type="radio" id="star4" name="rating" value="4" />
                  <label class="full" for="star4" title="Pretty good - 4 stars"></label>
                  <input type="radio" id="star3half" name="rating" value="3 and a half" />
                  <label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                  <input type="radio" id="star3" name="rating" value="3" />
                  <label class="full" for="star3" title="Meh - 3 stars"></label>
                  <input type="radio" id="star2half" name="rating" value="2 and a half" />
                  <label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                  <input type="radio" id="star2" name="rating" value="2" />
                  <label class="full" for="star2" title="Kinda bad - 2 stars"></label>
                  <input type="radio" id="star1half" name="rating" value="1 and a half" />
                  <label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                  <input type="radio" id="star1" name="rating" value="1" />
                  <label class="full" for="star1" title="Sucks big time - 1 star"></label>
                  <input type="radio" id="starhalf" name="rating" value="half" />
                  <label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                </fieldset>
              </div>-->

              <h2>INDUSTRY</h2>
              <p>{{userObj.freelancer.industries && userObj.freelancer.industries.title ? userObj.freelancer.industries.title : ''}}</p>
              <h2>PRICE</h2>
              <p v-if="userObj.freelancer.price">${{userObj.freelancer.price }}</p>

              <h2>SALES METHOD</h2>
              <p
                v-if="subscription_type==2 || is_admin"
              >{{userObj.sales_method && userObj.sales_method.title ? userObj.sales_method.title : ''}}</p>
              <p v-else>
                <update-plan-text></update-plan-text>
              </p>

              <h2>CONTACT DETAILS</h2>
              <div v-if="subscription_type==2 || is_admin">
                <p>EMAIL: {{userObj.user.email ? userObj.user.email : ''}}</p>
                <p>CONTACT: {{userObj.user.phone ? userObj.user.phone : ''}}</p>
              </div>
              <div v-else>
                <update-plan-text></update-plan-text>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <h2>DESCRIPTION</h2>
            <p>{{userObj.freelancer.description ? userObj.freelancer.description : ''}}</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import { getClientsubscriptionType, isloginAdmin } from "../../utils/auth";
import updatePlanText from "../Clients/upgradePlantext";
export default {
  components: {
    updatePlanText,
  },
  data() {
    return {
      userObj: null,
      subscription_type: getClientsubscriptionType(),
      is_admin: isloginAdmin(),
    };
  },
  async created() {
    const id = this.$route.params.id;
    this.userObj = (await axios.get("/index.php/api/freelancer/" + id)).data;
  },
};
</script>