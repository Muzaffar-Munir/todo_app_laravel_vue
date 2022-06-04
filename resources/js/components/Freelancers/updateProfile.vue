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
              <h5>Please fill out the form to update your info.</h5>
              <section class="register-sec-profile">
                <div class="container">
                  <div class="row d-flex justify-content-center">
                    <div class="col-md-10 col-lg-12 col-xl-12">
                      <div class="registeration-form">
                        <form @submit.stop.prevent="Submit()">
                          <div class="form-spacing">
                            <div class="half-form">
                              <div class="form-group mb-2 custom-form registeration-form-1">
                                <input
                                  type="text"
                                  name="subject"
                                  class="form-control"
                                  placeholder="First Name"
                                  required
                                  v-model="updateFormObj.first_name"
                                  :class="[{'is-invalid': errorFor('first_name')}]"
                                />
                                <v-errors :errors="errorFor('first_name')"></v-errors>
                              </div>
                              <div class="form-group mb-2 custom-form registeration-form-2">
                                <input
                                  type="text"
                                  name="subject"
                                  class="form-control"
                                  placeholder="Last Name"
                                  required
                                  v-model="updateFormObj.last_name"
                                  :class="[{'is-invalid': errorFor('last_name')}]"
                                />
                                <v-errors :errors="errorFor('last_name')"></v-errors>
                              </div>
                            </div>

                            <div class="form-group mb-2 custom-form">
                              <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Email"
                                required
                                v-model="updateFormObj.email"
                                :class="[{'is-invalid': errorFor('email')}]"
                              />
                              <v-errors :errors="errorFor('email')"></v-errors>
                            </div>

                            <div class="form-group mb-2 custom-form">
                              <input
                                type="text"
                                name="text"
                                class="form-control"
                                placeholder="Phone"
                                required
                                v-model="updateFormObj.phone"
                                :class="[{'is-invalid': errorFor('phone')}]"
                              />
                              <v-errors :errors="errorFor('phone')"></v-errors>
                            </div>
                            <select
                              class="m-bottom registration-select freelaning-select"
                              required
                              v-model="updateFormObj.industry"
                              :class="[{'is-invalid': errorFor('industry')}]"
                            >
                              <option value>Prefered Industry</option>
                              <option
                                v-for="(data, index) of industries"
                                :key="index"
                                :value="data.id"
                              >{{data.title}}</option>
                            </select>
                            <v-errors :errors="errorFor('industry')"></v-errors>
                            <div class="form-group mb-2 custom-form">
                              <input
                                type="number"
                                name="text"
                                class="form-control"
                                placeholder="Price"
                                required
                                v-model="updateFormObj.price"
                                :class="[{'is-invalid': errorFor('price')}]"
                              />
                              <v-errors :errors="errorFor('price')"></v-errors>
                            </div>
                            <div class="row mt-4">
                              <div class="col-md-6 browser-content create-pic replace">
                                <div v-if="userData.user.profile_picture && !url">
                                  <img
                                    class="preview-image-width"
                                    :src="userData.user.profile_picture ? '/images/users/'+userData.user.profile_picture : '/assets/images/Untitled-1_10.jpg'"
                                  />
                                </div>
                                <div v-if="url && url.length">
                                  <img
                                    :src="url?url:'/images/Untitled-1_10.jpg'"
                                    class="preview-image-width"
                                  />
                                </div>
                              </div>
                              <div class="col-md-6 tab-responsive">
                                <file-upload
                                  class="btn-browser"
                                  :post-action="postAction"
                                  :extensions="extensions"
                                  :accept="accept"
                                  :multiple="multiple"
                                  :directory="directory"
                                  :size="size || 0"
                                  :thread="thread < 1 ? 1 : (thread > 5 ? 5 : thread)"
                                  v-model="updateFormObj.profile_picture"
                                  @input-filter="inputFilter"
                                  @input-file="inputFile"
                                  ref="upload"
                                >BROWSER</file-upload>
                              </div>
                            </div>
                            <select
                              class="m-bottom-1 registration-select freelaning-select"
                              v-model="updateFormObj.experience"
                            >
                              <option value>Experience</option>
                              <option value="1-2 years">1-2 years</option>
                              <option value="2-5 years">2-5 years</option>
                              <option value="5-10 years">5-10 years</option>
                              <option value="More than 10 years">More than 10 years</option>
                            </select>

                            <select
                              class="registration-select freelaning-select"
                              v-model="updateFormObj.sales_method"
                              required
                            >
                              <option value>Preffered Sales Method:</option>
                              <option value="In Person">In person</option>
                              <option
                                v-for="(data, index) of sales_methods"
                                :key="index"
                                :value="data.id"
                              >{{data.title}}</option>
                            </select>

                            <div class="form-group mb-2 custom-form">
                              <input
                                type="text"
                                name="text"
                                class="form-control"
                                placeholder="Preffered Contact"
                                required
                                v-model="updateFormObj.primary_contact"
                                :class="[{'is-invalid': errorFor('primary_contact')}]"
                              />
                              <v-errors :errors="errorFor('primary_contact')"></v-errors>
                            </div>
                          </div>
                          <div
                            class="form-group registration-contact create-account-content freelancing-bottom"
                          >
                            <button class="btn-registration mt-4 ml-5" type="submit">Update</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import validationErrors from "../../mixins/validationErrors";
import dashboardNavComponent from "./dashboardNav";
import { is422 } from "../../utils/response";
import { getSalesmethods, getIndustries } from "../../utils/getDatabseData";
export default {
  components: {
    dashboardNavComponent,
  },
  mixins: [validationErrors],
  data() {
    return {
      url: null,
      sales_methods: null,
      industries: null,
      isSuccess: false,
      loader: true,
      accept: "image/png,image/gif,image/jpeg,image/webp",
      extensions: "gif,jpg,jpeg,png,webp",
      minSize: 1024,
      size: 1024 * 1024 * 10,
      multiple: false,
      directory: false,
      thread: 3,
      name: "file",
      postAction: "/index.php/api/user",
      putAction: "/index.php/api/user",
      autoCompress: 1024 * 1024,
      errors: null,
      status: null,
      userData: null,
      uploadAuto: false,
      updateFormObj: {
        first_name: this.userData.user.first_name,
        last_name: this.userData.user.last_name,
        email: this.userData.user.email,
        industry: this.userData.freelancer.industry
          ? this.userData.freelancer.industry
          : "",
        price: this.userData.freelancer.price,
        profile_picture: [this.userData.user.profile_picture],
        experience: this.userData.freelancer.experience
          ? this.userData.freelancer.experience
          : "",
        phone: this.userData.user.phone,
        sales_method: this.userData.user.sales_method
          ? this.userData.user.sales_method
          : "",
        primary_contact: this.userData.freelancer.primary_contact,
      },
    };
  },
  watch: {
    "updateFormObj.profile_picture": function (val, oldVal) {
      if (
        this.updateFormObj.profile_picture &&
        this.updateFormObj.profile_picture[0] &&
        this.updateFormObj.profile_picture[0].blob
      ) {
        this.url = this.updateFormObj.profile_picture[0].blob;
      }
    },
  },
  beforeCreate() {
    if (localStorage.getItem("current_user")) {
      this.userData = JSON.parse(localStorage.getItem("current_user"));
    }
  },
  async created() {
    if (!this.userData && localStorage.getItem("current_user")) {
      this.userData = JSON.parse(localStorage.getItem("current_user"));
    }
    this.industries = await getIndustries();
    this.sales_methods = await getSalesmethods();
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
  methods: {
    // getting user to update localhstorage
    async getUser() {
      const userObj = (
        await axios.get(
          "/index.php/api/user/" +
            this.userData.user.id +
            "?profile-details=true",
          {
            withCredentials: true,
          }
        )
      ).data;
      localStorage.setItem("current_user", JSON.stringify(userObj));
      this.$router.push({
        name: "freelance-profile",
      });
    },
    Submit() {
      this.loader = true;
      const data = new FormData();
      data.append("first_name", this.updateFormObj.first_name);
      data.append("last_name", this.updateFormObj.last_name);
      data.append("email", this.updateFormObj.email);
      data.append("phone", this.updateFormObj.phone);
      data.append("industry", this.updateFormObj.industry);
      data.append("price", this.updateFormObj.price);
      data.append("experience", this.updateFormObj.experience);
      data.append("sales_method", this.updateFormObj.sales_method);
      data.append("primary_contact", this.updateFormObj.primary_contact);

      data.append("_method", "PATCH");
      if (
        this.updateFormObj.profile_picture[0] != null &&
        this.updateFormObj.profile_picture[0].file
      ) {
        data.append(
          "profile_picture",
          this.updateFormObj.profile_picture[0].file
        );
      }
      axios
        .post("/index.php/api/freelancer/" + this.userData.freelancer.id, data)
        .then((response) => {
          if (response.status == 200) {
            this.getUser();
            this.loader = false;
          }
        })
        .catch((error) => {
          if (is422(error)) {
            this.loader = false;
            this.errors = error.response.data.errors;
          }
          this.status = error.response.status;
        })
        .then(() => {
          this.loader = false;
        });
    },
    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Add file

        // Filter non-image file
        // Will not be added to files
        if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
          return prevent();
        }
        // Create the 'blob' field for thumbnail preview
        newFile.blob = "";
        let URL = window.URL || window.webkitURL;
        if (URL && URL.createObjectURL) {
          newFile.blob = URL.createObjectURL(newFile.file);
        }
      }

      if (newFile && oldFile) {
        // Update file

        // Increase the version number
        if (!newFile.version) {
          newFile.version = 0;
        }
        newFile.version++;
      }

      if (!newFile && oldFile) {
        // Remove file
        // Refused to remove the file
        // return prevent()
      }
    },
    // add, update, remove File Event
    inputFile(newFile, oldFile) {
      if (newFile && oldFile) {
        // update
        if (newFile.active && !oldFile.active) {
          // beforeSend
          // min size
          if (
            newFile.size >= 0 &&
            this.minSize > 0 &&
            newFile.size < this.minSize
          ) {
            this.$refs.upload.update(newFile, { error: "size" });
          }
        }
        if (newFile.progress !== oldFile.progress) {
          // progress
        }
        if (newFile.error && !oldFile.error) {
          // error
        }
        if (newFile.success && !oldFile.success) {
          // success
        }
      }
      if (!newFile && oldFile) {
        // remove
        if (oldFile.success && oldFile.response.id) {
          // $.ajax({
          //   type: 'DELETE',
          //   url: '/upload/delete?id=' + oldFile.response.id,
          // })
        }
      }
      // Automatically activate upload
      if (
        Boolean(newFile) !== Boolean(oldFile) ||
        oldFile.error !== newFile.error
      ) {
        if (this.uploadAuto && !this.$refs.upload.active) {
          this.$refs.upload.active = true;
        }
      }
    },
  },
};
</script>