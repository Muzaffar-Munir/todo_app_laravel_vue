<template>
  <div class="width-90">
    <div class="tab w-100">
      <router-link :to="{name:'freelance-profile'}">
        <button class="tablinks create" id="profileTab">Dashboard</button>
      </router-link>
      <router-link :to="{name:'freelance-profile-update'}">
        <button class="tablinks" id="updateTab">Update Profile</button>
      </router-link>

      <router-link :to="{name:'freelance-subscribed-companies'}">
        <button class="tablinks cancel" id="cancelTab">Subscribed Companies</button>
      </router-link>

      <router-link :to="{name:'freelance-applied-applied'}">
        <button class="tablinks cancel" id="cancelTab">Applied Jobs</button>
      </router-link>
      <router-link :to="{name:'freelance-reset-password'}">
        <button class="tablinks reset" id="resetTab">Password Reset</button>
      </router-link>
      <button
        id="logoutTab"
        class="tablinks logout"
        data-toggle="modal"
        data-target="#logOutModal"
      >Logout</button>
    </div>
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
  </div>
</template>
<style scoped>
.tab:hover{
   text-decoration: none;
}
.active{
  color: beige;
}
</style>
<script>
import { logOut } from '../../utils/auth';
export default {
  methods: {
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
          logOut();
          if (response.status && response.status == 204) {
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
};
</script>