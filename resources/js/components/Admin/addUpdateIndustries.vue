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
                      <h5>{{ !id?'Create New':'Update' }} Industry</h5>
                    </div>
                  </div>
                </div>
                <div class="create-account-form">
                  <form @submit.stop.prevent="industrySubmit()">
                    <div class="form-group mb-2 custom-form">
                      <input
                        type="text"
                        name="text"
                        class="form-control"
                        placeholder="Enter title of industry"
                        required
                        autofocus
                        v-model="title"
                        :class="[{'is-invalid': errorFor('title')}]"
                      />
                      <v-errors :errors="errorFor('title')"></v-errors>
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
      title: null,
      errors: null,
      status: null,
      id: null,
    };
  },
  methods: {
    industrySubmit() {
      this.loader = true;
      if (this.id) {
        axios
          .put("/index.php/api/industries/" + this.id, { title: this.title })
          .then((response) => {
            if (response.status && response.status == 200) {
              this.title = null;
              this.$router.push({ name: "industries" });
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
          .post("/index.php/api/industries", { title: this.title })
          .then((response) => {
            if (response.status && response.status == 200) {
              this.title = null;
              this.loader = false;
              this.$router.push({ name: "industries" });
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
  created() {
    if (this.$route.params.id) {
      this.id = this.$route.params.id;
      this.title = this.$route.params.title ? this.$route.params.title : "";
    }
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
};
</script>