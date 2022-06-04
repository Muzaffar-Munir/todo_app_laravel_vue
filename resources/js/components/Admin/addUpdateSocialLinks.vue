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

              <!-- start content-->
              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <div class="new-btn">
                      <h5>{{ !id?'Create New':'Update' }} Social Link</h5>
                    </div>
                  </div>
                </div>
                <div class="create-account-form">
                  <form @submit.stop.prevent="industrySubmit()">
                    <div class="form-group mb-2 custom-form">
                      <select
                        class="registration-select freelaning-select mb-4"
                        v-model="socialform.type"
                        required
                        :class="[{'is-invalid': errors && errors.hasOwnProperty('type') ?'is-invalid' :''}]"
                      >
                        <option value>Select type of social link?</option>
                        <option value="Facebook">Facebook</option>
                        <option value="Instagram">Instagram</option>
                        <option value="Twitter">Twitter</option>
                        <option value="Linkedin">Linkedin</option>
                      </select>
                      <v-errors :errors="errorFor('type')"></v-errors>
                      <div v-if="errors && errors.hasOwnProperty('type')">
                        <span style="color:#b22222">The type has already been taken</span>
                      </div>
                    </div>
                    <div class="form-group mb-2 custom-form">
                      <input
                        type="url"
                        name="text"
                        class="form-control"
                        placeholder="Enter URL of your social link"
                        required
                        autofocus
                        v-model="socialform.url"
                        :class="[{'is-invalid': errorFor('url')}]"
                      />
                      <v-errors :errors="errorFor('url')"></v-errors>
                    </div>
                    <div class="create-account-content">
                      <button class="mt-4" type="submit">{{ !id?'SAVE':'UPDATE' }}</button>
                    </div>
                  </form>
                </div>
              </div>
              <!-- end -->
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
      id: null,
      socialform: {
        type: "",
        url: null,
      },
    };
  },
  methods: {
    industrySubmit() {
      this.loader = true;
      if (this.id) {
        axios
          .put("/index.php/api/social_links/" + this.id, this.socialform)
          .then((response) => {
            if (response.status && response.status == 200) {
              this.$router.push({ name: "social-links" });
            }
          })
          .catch((error) => {
            this.loader = false;
            if (is422(error)) {
              this.errors = error.response.data.errors;
            }
            this.status = error.response.status;
          })
          .then(() => {
            this.loader = false;
          });
      } else {
        axios
          .post("/index.php/api/social_links", this.socialform)
          .then((response) => {
            if (response.status && response.status == 200) {
              this.loader = false;
              this.$router.push({ name: "social-links" });
            }
          })
          .catch((error) => {
            this.loader = false;
            if (is422(error)) {
              this.errors = error.response.data.errors;
            }
            this.status = error.response.status;
          })
          .then(() => {
            this.loader = false;
          });
      }
    },
  },
  async created() {
    if (this.$route.params.id) {
      this.id = this.$route.params.id;
      this.socialform = (
        await axios.get("/index.php/api/social_links/" + this.id)
      ).data;
    }
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
};
</script>