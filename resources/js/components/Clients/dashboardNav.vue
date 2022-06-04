<template>
  <div class="width-90">
    <div class="tab w-100">
      <router-link :to="{name:'create-service'}">
        <button class="tablinks create" id="profileTab">Create an Ad</button>
      </router-link>
      <router-link :to="{name:'update-profile'}">
        <button class="tablinks" id="updateTab">Update Profile</button>
      </router-link>
      <router-link :to="{name:'reset-password'}">
        <button class="tablinks reset" id="resetTab">Password Reset</button>
      </router-link>
      <router-link :to="{name:'client-subscription'}">
        <button class="tablinks reset">My Subscription</button>
      </router-link>
       <router-link :to="{name:'client-payments'}">
        <button class="tablinks reset">My Payments</button>
      </router-link>
      <router-link
        :to="{name:'cancel-subscription'}"
        v-if="current_user && current_user.client && (current_user.client.subscription_type==1 || current_user.client.subscription_type==2)"
      >
        <button class="tablinks cancel" id="cancelTab">Cancel Subscription</button>
      </router-link>

      <button
        id="logoutTab"
        class="tablinks logout"
        data-toggle="modal"
        data-target="#logOutModal"
      >Logout</button>
    </div>
    <!-- Logout Modal -->
    <div
      class="modal fade model-style"
      id="logOutModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="pop-up-setting" style="display: flex; align-items: center;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to logout?</p>
              <div class="view-btn view-delete">
                <button class="edit" @click.stop.prevent="logout()">YES</button>
                <button class="delete" data-dismiss="modal">NO</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ending modal -->
    <!-- plans -->
    <div
      class="modal fade model-style"
      id="clientPlansModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      ref="clientPlansModal"
    >
      <div class="pop-up-setting" style="display: flex; align-items: center;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <!-- <h6></h6> -->
            </div>
            <div class="modal-body">
              <h6>Do you wants to update your Plan</h6>
            </div>
            <div class="modal-footer">
              <div class="view-btn view-delete">
                <button class="edit" @click.stop.prevent="updatePlan()">Yes</button>
                <button class="delete" data-dismiss="modal">NO</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ending modal -->
  </div>
</template>
<style scoped>
.tab:hover {
  text-decoration: none;
}
</style>
<script>
import { logOut } from "../../utils/auth";
export default {
  props: ["show"],
  data() {
    return {
      current_user: null,
    };
  },
  methods: {
    // close update plan modal and redirect to subscriptions

    updatePlan() {
      $("body").removeClass("modal-open");
      $(".fade").removeClass("modal-backdrop");
      $("body").css("padding-right", "0px");
      $("#clientPlansModal").modal("hide");
      this.$router.push({ name: "subscriptionPlans" });
    },
    openTab(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      // evt.currentTarget.className += " active";
      // document.getElementById(cityName).classList.add("active");
      document.getElementById(evt).classList.add("active");
    },
    logout() {
      axios
        .post("/index.php/logout")
        .then((response) => {
          if (response.status && response.status == 204) {
            logOut();
            localStorage.removeItem("current_user");
            $("body").removeClass("modal-open");
            $(".fade").removeClass("modal-backdrop");
            $("body").css("padding-right", "0px");
            this.$router.push({ name: "home" });
          }
        })
        .catch((err) => {});
    },
  },
  mounted() {
    if (localStorage.getItem("current_user")) {
      this.current_user = JSON.parse(localStorage.getItem("current_user"));
      const isShowMOdal = JSON.parse(
        localStorage.getItem("show_subscription_update_modal")
      );
      if (
        localStorage.getItem("show_subscription_update_modal") &&
        isShowMOdal == true
      ) {
        // $("#clientPlansModal").modal("show");
        // localStorage.setItem("show_subscription_update_modal", false);
      }
      setTimeout(() => {
        this.loader = false;
      }, 1000);
    }
  },
};
</script>