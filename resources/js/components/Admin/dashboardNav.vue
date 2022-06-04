<template>
  <div class="width-90">
    <div class="tab w-100">
      <router-link :to="{name:'admin-listed-services'}">
        <button class="tablinks create" id="profileTab">Services</button>
      </router-link>
      <router-link :to="{name:'admin-listed-users'}">
        <button class="tablinks">Users</button>
      </router-link>
      <router-link :to="{name:'admin-listed-admins'}">
        <button class="tablinks">Admin Users</button>
      </router-link>
      <router-link :to="{name:'sales-methods'}">
        <button class="tablinks">Sales Methods</button>
      </router-link>
      <router-link :to="{name:'industries'}">
        <button class="tablinks">Industries</button>
      </router-link>
      <router-link :to="{name:'social-links'}">
        <button class="tablinks">Social Links</button>
      </router-link>
      <router-link :to="{name:'admin-listed-queries'}">
        <button class="tablinks">Contact Queries</button>
      </router-link>
      <router-link :to="{name:'admin-listed-cancelled-subscription'}">
        <button class="tablinks">Cancelled Subscriptions</button>
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
.tab:hover {
  text-decoration: none;
}
</style>
<script>
import { logOutAdmin } from "../../utils/auth";
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
          if (response.status && response.status == 204) {
            logOutAdmin();
            localStorage.removeItem("admin_user");
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