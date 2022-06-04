<template>
  <div>
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <!-- section-top-->
    <section class="create-account-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h3>Dashboard</h3>
          </div>
        </div>
      </div>
    </section>

    <section class="create-account">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 tab-responsive">
            <dashboard-nav-component></dashboard-nav-component>
          </div>

          <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
            <div id="update" class="tabcontent" style="display:block">
              <div class="create-account-content"></div>
              <h5>Are you sure you want to cancel?</h5>
              <div class="create-account-form">
                <form @submit.stop.prevent="submit()">
                  <div class="form-group mb-2 custom-form">
                    <textarea
                      class="form-control foam-border comment-box"
                      placeholder="Please Leave Feeback to Help us Improve!"
                      rows="6"
                      required
                      autofocus
                      cols="50"
                      name="comment"
                      v-model="form.reason"
                    ></textarea>
                  </div>

                  <div class="create-account-content">
                    <button class="mt-4" type="submit">CANCEL</button>
                  </div>
                </form>
                <!-- Modal -->
                <div
                  class="modal fade model-style"
                  id="exampleModal"
                  tabindex="-1"
                  role="dialog"
                  aria-labelledby="exampleModalLabel"
                  aria-hidden="true"
                >
                  <div class="pop-up-setting" style="display: flex; align-items: center;">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            @click.prevent="showModal=false"
                          >
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>
                            Thank you! for using our service, your feedback is most appreciated.
                            We hope to see you again!
                          </p>
                          <img src="./../../../../public/assets/images/smily-face.png" alt="smile" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import dashboardNavComponent from "./dashboardNav";
import { is422 } from "../../utils/response";
import validationErrors from "../../mixins/validationErrors";
export default {
  components: {
    dashboardNavComponent,
  },
  mixins: [validationErrors],
  data() {
    return {
      loader: true,
      errors: null,
      status: null,
      user: null,
      showModal: false,
      form: {
        reason: null,
        user: null,
      },
    };
  },
  watch: {
    showModal: function () {
      if (this.showModal == false) {
        // do something
        axios.post("/index.php/logout");
        this.$router.push({ name: "home" });
        localStorage.removeItem("admin_user");
        localStorage.removeItem("current_user");
        localStorage.removeItem("isLoggedIn");
        localStorage.removeItem("isAdmin");
        localStorage.removeItem("show_subscription_update_modal");
        $("body").removeClass("modal-open");
        $(".fade").removeClass("modal-backdrop");
        $("body").css("padding-right", "0px");
      }
    },
  },
  methods: {
    // $("#exampleModal").modal("show");
    submit() {
      this.loader = true;
      axios
        .post("/index.php/api/cancel_subscription", this.form)
        .then((response) => {
          if (response.status && response.status == 200) {
            $("#exampleModal").modal("show");
            this.showModal = true;
            this.loader = false;
          }
        })
        .catch((error) => {
          this.loader = false;
          if (is422(error)) {
            this.errors =
              error.response &&
              error.response.data &&
              error.response.data.errors
                ? error.response.data.errors
                : "";
          }
          this.status =
            error.response && error.response.status
              ? error.response.status
              : "";
        })
        .then((eee) => {
          //  this.$router.push({ name: "home" });
          this.loader = false;
        });
    },
  },
  created() {
    if (localStorage.getItem("current_user")) {
      this.user = JSON.parse(localStorage.getItem("current_user")).user;
      this.form.user = this.user.id;
    }
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
};
</script>