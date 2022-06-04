<template>
  <div>
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <!-- section-top-->
    <section class="register-form-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-12"></div>
        </div>
      </div>
    </section>

    <!-- staart plans -->
    <section class="services" v-if="!is_subscription_selected">
      <div class="container">
        <div class="row main-heading">
          <div class="col-md-12 text-center">
            <h1>Choose one of the following</h1>
          </div>
        </div>

        <div class="row service-box">
          <div class="col-12 col-md-12 col-lg-4 service-col">
            <div class="service-options">
              <div class="service-rate service-rate-1">
                <h3>COVID RELIEF OFFER</h3>
                <h1 class="top-rate">FREE</h1>
                <p>
                  <i>
                    Try for free till
                    <br />The end of 2020
                  </i>
                </p>
              </div>
              <div
                class="service-discription"
              >ENDS IN {{ years }} {{ months }} {{ days }} {{ hours }}H {{ minitues }}M</div>
              <div class="service-list">
                <ul>
                  <li>Display the following:</li>
                  <li>Product or service</li>
                  <li>Price and Commission</li>
                </ul>
              </div>

              <button class="btn-block" @click.stop.prevent="subscribe(0)">JOIN</button>
            </div>
          </div>

          <div class="col-12 col-md-12 col-lg-4 service-col">
            <div class="service-options">
              <div class="service-rate service-rate-2">
                <h3>30 DAYS SUBSCRIPTION</h3>
                <h1 class="top-rate">
                  <span>$299</span>
                </h1>
              </div>
              <div class="service-list">
                <ul>
                  <li>Display the following:</li>
                  <li>Product or service</li>
                  <li>Price and Commission</li>
                  <li>Prerequisites</li>
                  <li>Target Audience</li>
                  <li>Target Location</li>
                  <li>Preferred sales methods</li>
                </ul>
              </div>

              <button
                class="btn-block"
                @click.prevent="subscribe(1);selectedPlan=monthly_subscription; subscription_title='Monthly Plan'"
              >JOIN</button>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-4 service-col">
            <div class="service-options">
              <div class="service-rate service-rate-2">
                <h3>12 MONTHS SUBSCRIPTION</h3>
                <h1 class="top-rate">
                  <span>$2,499</span>
                </h1>
              </div>
              <div class="service-list">
                <ul>
                  <li>Display the following:</li>
                  <li>Product or service</li>
                  <li>Price and Commission</li>
                  <li>Prerequisites</li>
                  <li>Target Audience</li>
                  <li>Target Location</li>
                  <li>Preferred sales methods</li>
                  <li>Access to view Sales professional profiles</li>
                  <li>Top priority for your industry</li>
                  <li>Automated email sent to Sales professionals looking to work for your rate or industry</li>
                </ul>
              </div>
              <button
                class="btn-block"
                @click.prevent="subscribe(2);selectedPlan=annual_subscription; subscription_title='Annual Plan'"
              >JOIN</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="register-sec" v-if="is_subscription_selected">
      <div class="container">
        <div class="row mb-4 main-content">
          <h3>SELECTED SUBSCRIPTION OFFERS: COVID RELIEF OFFER</h3>
          <p>Please fill out the form to complete the registration.</p>
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-md-10 col-lg-9 col-xl-9">
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
                        v-model="signUpformObj.first_name"
                        required
                        autofocus
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
                        v-model="signUpformObj.last_name"
                        :class="[{'is-invalid': errorFor('last_name')}]"
                      />
                      <v-errors :errors="errorFor('last_name')"></v-errors>
                    </div>
                  </div>

                  <div class="form-group mb-2 custom-form">
                    <input
                      type="text"
                      name="text"
                      class="form-control"
                      placeholder="Address"
                      required
                      v-model="signUpformObj.address"
                      :class="[{'is-invalid': errorFor('address')}]"
                    />
                    <v-errors :errors="errorFor('address')"></v-errors>
                  </div>
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="email"
                      name="email"
                      class="form-control"
                      placeholder="Email"
                      required
                      v-model="signUpformObj.email"
                      :class="[{'is-invalid': errorFor('email')}]"
                    />
                    <v-errors :errors="errorFor('email')"></v-errors>
                  </div>

                  <div class="half-form">
                    <div class="form-group mb-2 custom-form registeration-form-1">
                      <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Password"
                        required
                        v-model="signUpformObj.password"
                        min="4"
                        @input="matchPassword()"
                        :class="[{'is-invalid': errorFor('password')}]"
                      />
                      <v-errors :errors="errorFor('password')"></v-errors>
                      <transition-group name="fade" v-if="errors">
                        <p v-for="(error, keyIndex) in errors" :key="keyIndex+'from'">
                          <span v-if="error.password" style="color:#b22222">{{ error.password }}</span>
                        </p>
                      </transition-group>
                    </div>

                    <div class="form-group mb-2 custom-form registeration-form-2">
                      <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Confirm Password"
                        required
                        @input="matchPassword()"
                        v-model="signUpformObj.confirm_password"
                        :class="[{'is-invalid': errorFor('confirm_password')}]"
                      />
                      <v-errors :errors="errorFor('confirm_password')"></v-errors>
                      <transition-group name="fade" v-if="errors">
                        <p v-for="(error, keyIndex) in errors" :key="keyIndex+'from'">
                          <span v-if="error.password" style="color:#b22222">{{ error.password }}</span>
                        </p>
                      </transition-group>
                    </div>
                  </div>
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="text"
                      name="text"
                      class="form-control"
                      placeholder="ABN/ACN"
                      required
                      v-model="signUpformObj.abn"
                      :class="[{'is-invalid': errorFor('abn')}]"
                    />
                    <v-errors :errors="errorFor('abn')"></v-errors>
                  </div>
                  <select
                    class="registration-select freelaning-select"
                    v-model="signUpformObj.sales_method"
                    required
                  >
                    <option value>Preffered Sales Method:</option>
                    <option
                      v-for="(data, index) of sales_methods"
                      :key="index"
                      :value="data.id"
                    >{{data.title}}</option>
                  </select>
                  <select
                    class="registration-select"
                    v-model="signUpformObj.location"
                    required
                    :class="[{'is-invalid': errorFor('location')}]"
                  >
                    <option value>Enter Target Location</option>
                    <option value="suburb">Suburb</option>
                    <option value="state">State</option>
                    <option value="country">Country</option>
                    <option value="none">None</option>
                  </select>
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="text"
                      name="text"
                      class="form-control"
                      placeholder="Phone"
                      required
                      v-model="signUpformObj.phone"
                      :class="[{'is-invalid': errorFor('phone')}]"
                    />
                    <v-errors :errors="errorFor('phone')"></v-errors>
                  </div>
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="text"
                      name="text"
                      class="form-control"
                      placeholder="Business Name"
                      required
                      v-model="signUpformObj.business_name"
                      :class="[{'is-invalid': errorFor('business_name')}]"
                    />
                    <v-errors :errors="errorFor('business_name')"></v-errors>
                  </div>
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="text"
                      name="text"
                      class="form-control"
                      placeholder="Business Address"
                      required
                      v-model="signUpformObj.business_address"
                      :class="[{'is-invalid': errorFor('business_address')}]"
                    />
                    <v-errors :errors="errorFor('business_address')"></v-errors>
                  </div>
                  <div class="form-group mb-2 custom-form">
                    <input
                      type="email"
                      name="email"
                      class="form-control"
                      placeholder="Referral Email Id"
                      v-model="signUpformObj.referal_email"
                      :class="[{'is-invalid': errorFor('referal_email')}]"
                    />
                    <v-errors :errors="errorFor('referal_email')"></v-errors>
                  </div>

                  <select class="registration-select" v-model="signUpformObj.source">
                    <option value>Select How Do You Find About Website?</option>
                    <option value="Google">Google</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Linkedin">Linkedin</option>
                    <option value="Instagram">Instagram</option>
                    <option value="Twitter">Twitter</option>
                    <option value="Youtube">Youtube</option>
                    <option value="Refferal">Refferal</option>
                  </select>
                  <div class="row mt-4">
                    <div class="col-md-6 browser-content create-pic replace">
                      <div v-if="url && url.length">
                        <img :src="url?url:'/images/Untitled-1_10.jpg'" class="preview-image-width" />
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
                        v-model="signUpformObj.profile_picture"
                        @input-filter="inputFilter"
                        @input-file="inputFile"
                        ref="upload"
                      >BROWSER</file-upload>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-12 registration-bottom">
                      <p>Receive 10% off your next subscription when you refer another business or sales professional to join.</p>
                    </div>
                  </div>
                </div>
                <div class="form-group registration-contact">
                  <p>
                    <input class="mr-3 register-checkbox" type="checkbox" name="checbox" required />
                    <span
                      class="cyan-words cursor-pointer"
                      data-toggle="modal"
                      data-target="#exampleModalScrollable"
                    >I’ve Read and I Accept terms and conditions.</span>
                  </p>
                  <button class="btn-registration mt-4 ml-5" type="submit">REGISTER</button>
                </div>
                <div class="alert alert-success alert-dismissible" v-if="isSuccess">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Success!</strong> Plz Login
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <terms-and-conditions></terms-and-conditions>
    </section>
    <!-- ending sign up -->

    <!-- view pricing modal -->

    <div
      class="modal fade model-style"
      id="paymentModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="pop-up-setting" style="display: flex; align-items: center;">
        <div class="modal-dialog width" role="document">
          <div class="modal-content">
            <div class="modal-header">
              Payment details
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="row" @submit.stop.prevent="submitPaymentMethod()">
                <div class="col-12 mb-2">
                  <label class="pull-left">Card Holder Name *</label>
                  <input
                    id="card-holder-name"
                    type="text"
                    placeholder="Card Holder Name *"
                    v-model="cname"
                    required
                    class="form-control mb-2"
                  />
                </div>
                <br />
                <div class="col-12 mb-2">
                  <label class="pull-left">Card</label>
                  <div id="card-element"></div>
                </div>

                <button
                  class="btn btn-info mt-3 pull-right centered-align"
                  id="add-card-button"
                  type="submit"
                >Save Payment Method</button>

                <div
                  v-show="paymentMethodsLoadStatus == 2 
    && paymentMethods.length == 0"
                  class="col-12"
                >No payment method added yet, please add a payment method.</div>

                <div
                  v-show="paymentMethodsLoadStatus == 2 
        && paymentMethods.length > 0"
                  class="col-12"
                >
                  <div class="mt-3 mb-3">OR</div>
                  <div
                    v-for="(method, key) in paymentMethods"
                    v-bind:key="'method-'+key"
                    v-on:click="paymentMethodSelected = method.id;selectedPlanTitle = method.selectedPlanTitle"
                    class="border rounded row p-1"
                    v-bind:class="{
            'bg-success text-light': paymentMethodSelected == method.id    
        }"
                  >
                    <div
                      class="col-2"
                    >{{ method.brand.charAt(0).toUpperCase() }}{{ method.brand.slice(1) }}</div>
                    <div
                      class="col-7"
                    >Ending In: {{ method.last_four }} Exp: {{ method.exp_month }} / {{ method.exp_year }}</div>
                    <div class="col-3">
                      <span v-on:click.stop="removePaymentMethod( method.id )">Remove</span>
                    </div>
                  </div>
                </div>
              </form>
              <button
                class="btn btn-info mt-3 pull-right pay-btn"
                id="add-card-button"
                v-if="paymentMethodSelected && paymentMethodSelected.length"
                @click.prevent="updateSubscription()"
                :disabled="loader"
              >Pay Now</button>

              <!-- <div class="view-btn view-delete pull-right">
                <button class="delete" data-dismiss="modal">Close</button>
              </div>-->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ending pricing modal -->

    <!-- Success modal -->

    <div
      class="modal fade model-style"
      id="paymentSuccessModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="paymentSuccessModalLabel"
      aria-hidden="true"
    >
      <div class="pop-up-setting" style="display: flex; align-items: center;">
        <div class="modal-dialog width" role="document">
          <div class="modal-content">
            <div class="modal-header">Payment {{ payment_status }}!</div>
            <div class="modal-body">
              <p
                class="text-left"
                v-if="payment_status=='success'"
              >Thanks for making the payment. You are successfully subscribed to {{ subscription_title && subscription_title=='Annual' ? '12 MONTHS SUBSCRIPTION': subscription_title && subscription_title=='Monthly'? '30 DAYS SUBSCRIPTION':'' }} package.</p>
              <div class="view-btn view-delete pull-right">
                <button class="edit" @click.stop.prevent="redirectToLogin()">Login</button>
                <button class="delete" data-dismiss="modal" v-if="payment_status=='failed'">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ending success modal -->
  </div>
</template>
<script>
import termsAndConditions from "../common/termsAndConditions";
import { getSalesmethods } from "../../utils/getDatabseData";
import validationErrors from "../../mixins/validationErrors";
import { is422 } from "../../utils/response";
export default {
  mixins: [validationErrors],
  components: {
    termsAndConditions,
  },
  computed: {
    hasErrors() {
      return 422 === this.status && this.errors !== null;
    },
  },
  data() {
    return {
      // stripe config
      stripeAPIToken: process.env.MIX_STRIPE_KEY,
      stripe: "",
      elements: "",
      card: "",
      intentToken: "",
      cname: "",
      addPaymentStatus: 0,
      addPaymentStatusError: "",
      paymentMethods: [],
      paymentMethodsLoadStatus: 0,
      paymentMethodSelected: {},
      selectedPlan: "",
      subscription_title: null,
      selectedPlanTitle: null,
      monthly_subscription: null,
      annual_subscription: null,
      referal_coupon: null,
      payment_status: null,
      is_referal: null,

      showPlans: true,
      url: null,
      userResponse: null,
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
      uploadAuto: false,
      status: null,
      loader: true,
      signUpformObj: {
        first_name: null,
        last_name: null,
        email: null,
        password: null,
        confirm_password: null,
        abn: null,
        source: "",
        address: null,
        profile_picture: [],
        business_name: null,
        business_address: null,
        sales_method: "",
        role: "client",
        referal_email: null,
        // subscription_type: null,
        phone: null,
        location: "",
      },
      sales_methods: null,
      errors: null,
      isSuccess: false,
      is_subscription_selected: false,
      subscription_type: null,
      diffDays: null,
      dayString: null,
      years: null,
      months: null,
      days: null,
      hours: null,
      minitues: null,
    };
  },
  watch: {
    "signUpformObj.profile_picture": function (val, oldVal) {
      if (
        this.signUpformObj.profile_picture &&
        this.signUpformObj.profile_picture[0] &&
        this.signUpformObj.profile_picture[0].blob
      ) {
        this.url = this.signUpformObj.profile_picture[0].blob;
      }
    },
  },
  async created() {
    this.sales_methods = await getSalesmethods();
    this.monthly_subscription = process.env.MIX_STRIPE_MONTHLY_SUBSCRIPTION;
    this.annual_subscription = process.env.MIX_STRIPE_ANNUAL_SUBSCRIPTION;
    // this.stripeAPIToken = process.env.MIX_STRIPE_KEY;
    setTimeout(() => {
      this.loader = false;
    }, 1000);
    this.getDifference();
  },
  methods: {
    // redirects to login page

    redirectToLogin() {
      $("body").removeClass("modal-open");
      $(".fade").removeClass("modal-backdrop");
      $("body").css("padding-right", "0px");
      $("#paymentSuccessModal").modal("hide");
      this.$router.push({ name: "home" });
    },

    // matching passwords
    matchPassword() {
      if (
        this.signUpformObj.password &&
        this.signUpformObj.confirm_password &&
        this.signUpformObj.password != this.signUpformObj.confirm_password
      ) {
        this.errors = [{ password: "password not matched" }];
        return;
      } else {
        return (this.errors = null);
      }
    },
    // form call to action for create client
    async Submit() {
      this.loader = true;

      const data = new FormData();
      data.append("first_name", this.signUpformObj.first_name);
      data.append("last_name", this.signUpformObj.last_name);
      data.append("email", this.signUpformObj.email);
      data.append("phone", this.signUpformObj.phone);
      data.append("password", this.signUpformObj.password);
      data.append("confirm_password", this.signUpformObj.confirm_password);
      data.append("source", this.signUpformObj.source);
      data.append("address", this.signUpformObj.address);
      data.append("business_name", this.signUpformObj.business_name);
      data.append("business_address", this.signUpformObj.business_address);
      data.append("referal_email", this.signUpformObj.referal_email);
      data.append("sales_method", this.signUpformObj.sales_method);
      data.append("role", this.signUpformObj.role);
      data.append("location", this.signUpformObj.location);
      data.append("abn", this.signUpformObj.abn);
      if (this.signUpformObj.profile_picture[0] != null) {
        data.append(
          "profile_picture",
          this.signUpformObj.profile_picture[0].file
        );
      }
      await axios
        .post("/index.php/api/user", data)
        .then((response) => {
          this.loader = false;
          if (response.status && response.status == 200) {
            this.isSuccess = true;
            this.userResponse = response.data;
            this.payonSignUp(this.userResponse);
          }
        })
        .catch((error) => {
          this.loader = false;
          if (is422(error)) {
            this.errors = error.response.data.errors;
          }
          this.status =
            error.response && error.response.status
              ? error.response.status
              : "";
        })
        .then(() => {
          this.loader = false;
        });
    },
    async getReferal(){
       if (
        this.signUpformObj.referal_email &&
        this.signUpformObj.referal_email != null &&
        this.signUpformObj.referal_email != "null" &&
        this.signUpformObj.referal_email != undefined
      ) {
        this.is_referal = (await axios.post("/index.php/api/clients/client-referal", {
          email: this.signUpformObj.referal_email,
        })).data;
        
         this.referal_coupon = process.env.MIX_REFERAL_DISCOUNT;
      }
    },
    subscribe(type) {
      this.loader = true;
      setTimeout(() => {
        this.subscription_type = type;
        this.is_subscription_selected = true;
        this.loader = false;
      }, 700);
    },
    async payonSignUp(user) {
      if (this.subscription_type == 0) {
        setTimeout(() => {
          this.$router.push({ name: "home"});
          this.isSuccess = false;
        }, 2000);
      } else {
        this.isSuccess = false;
        await this.loadIntent();
        this.getReferal();
        $("#paymentModal").modal("show");
      }
    },

    // stripe config
    /*
        Includes Stripe.js dynamically
    */
    includeStripe(URL, callback) {
      let documentTag = document,
        tag = "script",
        object = documentTag.createElement(tag),
        scriptTag = documentTag.getElementsByTagName(tag)[0];
      object.src = "//" + URL;
      if (callback) {
        object.addEventListener(
          "load",
          function (e) {
            callback(null, e);
          },
          false
        );
      }
      scriptTag.parentNode.insertBefore(object, scriptTag);
    },
    configureStripe() {
      this.stripe = Stripe(this.stripeAPIToken);

      this.elements = this.stripe.elements();
      this.card = this.elements.create("card");

      this.card.mount("#card-element");
    },
    async loadIntent() {
      axios
        .get(
          "/index.php/api/users/setup-intent?user_id=" + this.userResponse.id
        )
        .then(
          function (response) {
            this.intentToken = response.data;
          }.bind(this)
        );
    },
    async submitPaymentMethod() {
      this.addPaymentStatus = 1;
      this.stripe
        .confirmCardSetup(this.intentToken.client_secret, {
          payment_method: {
            card: this.card,
            billing_details: {
              name: this.cname,
            },
          },
        })
        .then(
          function (result) {
            if (result.error) {
              this.addPaymentStatus = 3;
              this.addPaymentStatusError = result.error.message;
            } else {
              this.savePaymentMethod(result.setupIntent.payment_method);
              this.addPaymentStatus = 2;
              this.card.clear();
              this.cname = "";
            }
          }.bind(this)
        );
    },
    /*
    Saves the payment method for the user and
    re-loads the payment methods.
*/
    savePaymentMethod(method) {
      axios
        .post("/index.php/api/users/payments", {
          payment_method: method,
          user: this.userResponse.id,
        })
        .then(
          function () {
            this.loadPaymentMethods();
          }.bind(this)
        );
    },
    removePaymentMethod(paymentID) {
      axios
        .post("/index.php/api/users/remove-payment", {
          id: paymentID,
          user: this.userResponse.id,
        })
        .then(
          function (response) {
            this.loadPaymentMethods();
          }.bind(this)
        );
    },
    /*
    Loads all of the payment methods for the
    user.
*/
    loadPaymentMethods() {
      this.paymentMethodsLoadStatus = 1;

      axios
        .get(
          "/index.php/api/users/payment-methods?user_id=" + this.userResponse.id
        )
        .then(
          function (response) {
            this.paymentMethods = response.data;

            this.paymentMethodsLoadStatus = 2;
          }.bind(this)
        );
    },
    updateSubscription() {
      this.loader = true;
      const data = {};
      data.plan = this.selectedPlan;
      data.payment = this.paymentMethodSelected;
      data.user = this.userResponse.id;
      data.subscription_title = this.subscription_title;
      data.is_signup = true;

      if (this.is_referal) {
        if (this.referal_coupon) {
          data.coupon = this.referal_coupon;
        } else {
          data.coupon = "referal";
        }
      }
      axios
        .put("/index.php/api/users/subscription", data)
        .then(
          function (response) {
            this.loader = false;
            $("#paymentModal").modal("hide");
            this.payment_status = "success";
            $("#paymentSuccessModal").modal("show");
          }.bind(this)
        )
        .catch((errors) => {
          $("body").removeClass("modal-open");
          $(".fade").removeClass("modal-backdrop");
          $("body").css("padding-right", "0px");
          $("#paymentModal").modal("hide");
          $("#paymentSuccessModal").modal("show");
          if (errors.response && errors.response.status == 406) {
            this.payment_status = "failed";
          }

          this.loader = false;
        });
    },

    // Days to months, years logic
    getDifference() {
      // finding diffrence between current date and end of current date for time
      var today = new Date();
      var month = today.getMonth() + 1;
      // var endToday = new Date("2020-10-19 23:59:59");
      var endToday = new Date(
        today.getFullYear() + "-" + month + "-" + today.getDate() + " 23:59:59"
      );
      var diffMs = endToday - today; // milliseconds between now & end of day
      this.hours = Math.floor((diffMs % 86400000) / 3600000); // hours
      this.minitues = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes

      const date_1 = new Date();
      const date_2 = new Date("12/31/" + new Date().getFullYear());
      //convert to UTC
      var date2_UTC = new Date(
        Date.UTC(
          date_2.getUTCFullYear(),
          date_2.getUTCMonth(),
          date_2.getUTCDate()
        )
      );
      var date1_UTC = new Date(
        Date.UTC(
          date_1.getUTCFullYear(),
          date_1.getUTCMonth(),
          date_1.getUTCDate()
        )
      );

      var yAppendix, mAppendix, dAppendix;

      //--------------------------------------------------------------
      var days = date2_UTC.getDate() - date1_UTC.getDate();
      if (days < 0) {
        date2_UTC.setMonth(date2_UTC.getMonth() - 1);
        days += DaysInMonth(date2_UTC);
      }
      //--------------------------------------------------------------
      var months = date2_UTC.getMonth() - date1_UTC.getMonth();
      if (months < 0) {
        date2_UTC.setFullYear(date2_UTC.getFullYear() - 1);
        months += 12;
      }
      //--------------------------------------------------------------
      var years = date2_UTC.getFullYear() - date1_UTC.getFullYear();

      if (years > 1) yAppendix = " years";
      else yAppendix = " year";
      if (months > 1) mAppendix = " months";
      else mAppendix = " month";
      if (days > 1) dAppendix = " days";
      else dAppendix = " day";

      let string = "";
      if (years != 0) {
        this.years = years + "Y";
        string = years + yAppendix + ", ";
      }
      if (months != 0) {
        this.months = months + "M";
        string += months + mAppendix + ", and ";
      }
      if (days != 0) {
        this.days = days + "D";
        string += days + dAppendix + ", ";
      }
      this.dayString = string;
      return this.dayString;
    },

    DaysInMonth(date2_UTC) {
      var monthStart = new Date(
        date2_UTC.getFullYear(),
        date2_UTC.getMonth(),
        1
      );
      var monthEnd = new Date(
        date2_UTC.getFullYear(),
        date2_UTC.getMonth() + 1,
        1
      );
      var monthLength = (monthEnd - monthStart) / (1000 * 60 * 60 * 24);
      return monthLength;
    },
    // image upload
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
    //
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
  mounted() {
    this.includeStripe(
      "js.stripe.com/v3/",
      function () {
        this.configureStripe();
      }.bind(this)
    );
    if (this.userResponse) {
      this.loadIntent();
      this.loadPaymentMethods();
    }
  },
};
</script>
<style scoped>
.display-none {
  display: none;
}
.cursor-pointer {
  cursor: pointer;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.bg-success {
  background-color: #151313 !important;
  opacity: 0.8;
}
</style>  