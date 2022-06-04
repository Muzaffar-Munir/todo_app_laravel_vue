import VueRouter from "vue-router";


// shared 
import IndexComponent from "./components/Index";
import contactUsComponent from "./components/common/contactUs";
import indexListFreelancers from "./components/Freelancers/indexListFreelancers";
import IndexListClientsComponent from "./components/Clients/indexListClients";
import ForgetPasswordReset from "./components/common/forgotPasswordReset";
import aboutUsComponent from "./components/common/about-us";
import privacyPolicyComponent from "./components/common/privacy-policy";
import termsOfUseComponent from "./components/common/terms-of-use";
import faqsComponent from "./components/common/faqs";

// freelancer components

import userProfileComponent from "./components/common/userProfile";
import updateProfileComponent from "./components/Freelancers/updateProfile";
import FreelancerSignUpComponent from "./components/Freelancers/signUp";
import FreelancerDashboardComponent from "./components/Freelancers/dashboardFreelancer";

// new freelancer components
import freelancerDashboardProfile from './components/Freelancers/dashboardProfile';
import freelancerUpdateProfile from './components/Freelancers/updateProfile';
import freelancerSubscribedCompanies from './components/Freelancers/subscribedCompanies';
import freelancerAppliedJobs from './components/Freelancers/appliedJobs';

import freelancerResetPassword from './components/Freelancers/resetPassword';

// clients

import updateProfileNewComponent from "./components/Clients/UpdateProfilenew";
import resetPasswordComponent from "./components/Clients/resetPassword";
import ClientsSignUpComponent from "./components/Clients/signUp";
import ClientsDashboardComponent from "./components/Clients/dahboardClient";
import subscriptionPlansComponent from "./components/Clients/subscriptionPlans";
import cancelSubscriptionComponent from "./components/Clients/cancelSubscription";
import currentSubscriptionComponent from "./components/Clients/clientSubscription";
import myPaymentsComponent from "./components/Clients/myPayments";

// services
import ClientsViewServiceComponent from "./components/Services/viewServices";
import ClientsListServicesComponent from "./components/Clients/listServices";
import updateClientServiceComponent from "./components/Clients/updateClientService";
import coomonListServices from "./components/Services/indexlistServices";
import indexViewServicesComponent from "./components/Services/indexViewService";
import newCreateClientService from "./components/Services/newCreateClientService";


// Admin routes
import AdminLogin from './components/Admin/Login';
import AdminListedServices from './components/Admin/listedServices';
import AdminListedUsers from './components/Admin/listedUsers';
import ListedAdmins from './components/Admin/listedAdmins';
import AdminListedContactQueries from './components/Admin/listedContactQueries';
import paymentHistory from './components/Admin/paymentHistory';
import SalesMethods from './components/Admin/salesMethods';
import addUpdateSalesMethods from './components/Admin/addUpdateSalesMethod';
import addUpdateIndustries from './components/Admin/addUpdateIndustries.vue';
import Industries from './components/Admin/industries';
import socialLinks from './components/Admin/socialLinks';
import addUpdateSocialLinks from './components/Admin/addUpdateSocialLinks';
import listedCancelledSubscriptions from './components/Admin/listedCancelledSubscriptions';

import { isLoggedIn, userRole, isloginAdmin } from "./utils/auth";

const routes = [
    {
        path: "/",
        name: "home",
        component: IndexComponent,
        meta: {
            NoLoginRequired: false,
        }
    },
    {
        path: "/forget-password-reset/:id",
        name: "forget-password-reset",
        component: ForgetPasswordReset,
        meta: {
            NoLoginRequired: false,
        }
    },
    {
        path: "/about-us",
        name: "about-us",
        component: aboutUsComponent,
        meta: {
            NoLoginRequired: false,
        }
    },
    {
        path: "/privacy-policy",
        name: "privacy-policy",
        component: privacyPolicyComponent,
        meta: {
            NoLoginRequired: false,
        }
    },
    {
        path: "/faqs",
        name: "faqs",
        component: faqsComponent,
        meta: {
            NoLoginRequired: false,
        }
    },
    {
        path: "/terms-of-use",
        name: "terms-of-use",
        component: termsOfUseComponent,
        meta: {
            NoLoginRequired: false,
        }
    },
    {
        path: "/freelancer/signUp",
        name: "freelancerSignUp",
        component: FreelancerSignUpComponent,
        meta: {
            NoLoginRequired: false,
        }
    },
    {
        path: "/client/Signup",
        component: ClientsSignUpComponent,
        name: "clientSignup",
        meta: {
            NoLoginRequired: false,
        }
    },
    {
        path: "/home/list-clients",
        component: IndexListClientsComponent,
        name: "indexListClients",
        meta: {
            NoLoginRequired: false,
        }
    },
    {
        path: "/view-service/:id",
        component: ClientsViewServiceComponent,
        name: "viewService",
        meta: {
            NoLoginRequired: false,
        }
    },
    {
        path: "/home/list-freelancers",
        component: indexListFreelancers,
        name: "listFreelancers",
        meta: {
            NoLoginRequired: false,
        }
    },
    {
        path: "/user-profile/:id",
        component: userProfileComponent,
        name: "userProfile",
        meta: {
            NoLoginRequired: false,
        }
    },
    {
        path: "/update-profile/:id",
        component: updateProfileComponent,
        name: "updateProfile",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
        }
    },

    {
        path: "/contact-us",
        component: contactUsComponent,
        name: "contactUs",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
        }
    },
    {
        path: "/home/services",
        component: coomonListServices,
        name: "services",
        meta: {
            NoLoginRequired: false,
        }
    },
    {
        path: "/home/view-service/:id",
        component: indexViewServicesComponent,
        name: "indexViewService",
        meta: {
            NoLoginRequired: false,
        }
    },

    // clients routes 
    {
        path: "/dashboard/create",
        component: newCreateClientService,
        name: "create-service",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: true,
            FreelancerLoginRequired: false,
        }
    },
    {
        path: "/dashboard/update",
        component: updateProfileNewComponent,
        name: "update-profile",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: true,
            FreelancerLoginRequired: false,
        }
    },
    {
        path: "/dashboard/reset-password",
        component: resetPasswordComponent,
        name: "reset-password",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: true,
            FreelancerLoginRequired: false,
        }
    },
    {
        path: "/client/list-services",
        component: ClientsListServicesComponent,
        name: "clientListServices",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: true,
            FreelancerLoginRequired: false,
        }
    },
    {
        path: "/client/update-service/:id",
        component: updateClientServiceComponent,
        name: "updateClientService",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: true,
            FreelancerLoginRequired: false,
        }
    },
    {
        path: "/client/cancel-subscription",
        component: cancelSubscriptionComponent,
        name: "cancel-subscription",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: true,
            FreelancerLoginRequired: false,
        }
    },
    {
        path: "/client/subscription-plans",
        component: subscriptionPlansComponent,
        name: "subscriptionPlans",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: true,
            FreelancerLoginRequired: false,
        }
    },

    {
        path: "/client/client-subscription",
        component: currentSubscriptionComponent,
        name: "client-subscription",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: true,
            FreelancerLoginRequired: false,
        }
    },
    {
        path: "/client/client-payments",
        component: myPaymentsComponent,
        name: "client-payments",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: true,
            FreelancerLoginRequired: false,
        }
    },

    //freelancer routes 
    {
        path: "/freelancer/profile",
        component: freelancerDashboardProfile,
        name: "freelance-profile",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: true,
        }
    },
    {
        path: "/freelancer/update",
        component: freelancerUpdateProfile,
        name: "freelance-profile-update",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: true,
        }
    },
    {
        path: "/freelancer/subscribed-companies",
        component: freelancerSubscribedCompanies,
        name: "freelance-subscribed-companies",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: true,
        }
    },
    {
        path: "/freelancer/applied-jobs",
        component: freelancerAppliedJobs,
        name: "freelance-applied-applied",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: true,
        }
    },
    {
        path: "/freelancer/reset-password",
        component: freelancerResetPassword,
        name: "freelance-reset-password",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: true,
        }
    },

    // admin routes
    {
        path: "/admin/login",
        component: AdminLogin,
        name: "admin-login",
        meta: {
            NoLoginRequired: true,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: false
        }
    },
    {
        path: "/admin/listed-services",
        component: AdminListedServices,
        name: "admin-listed-services",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },
    {
        path: "/admin/listed-cancelled-subscription",
        component: listedCancelledSubscriptions,
        name: "admin-listed-cancelled-subscription",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },
    {
        path: "/admin/listed-users",
        component: AdminListedUsers,
        name: "admin-listed-users",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },
    {
        path: "/admin/listed-queries",
        component: AdminListedContactQueries,
        name: "admin-listed-queries",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },
    {
        path: "/admin/listed-admins",
        component: ListedAdmins,
        name: "admin-listed-admins",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },
    {
        path: "/admin/payment-history",
        component: paymentHistory,
        name: "admin-payment-history",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },
    {
        path: "/admin/sales-methods",
        component: SalesMethods,
        name: "sales-methods",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },
    {
        path: "/admin/sales-methods-add",
        component: addUpdateSalesMethods,
        name: "sales-methods-add",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },
    {
        path: "/admin/sales-methods-update/:id",
        component: addUpdateSalesMethods,
        name: "sales-methods-update",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },
    {
        path: "/admin/industries",
        component: Industries,
        name: "industries",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    }, 
    {
        path: "/admin/industry-add",
        component: addUpdateIndustries,
        name: "industry-add",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },
    {
        path: "/admin/industry-update/:id",
        component: addUpdateIndustries,
        name: "industry-update",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },
    {
        path: "/admin/social-links",
        component: socialLinks,
        name: "social-links",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },
    {
        path: "/admin/social-links-add",
        component: addUpdateSocialLinks,
        name: "social-links-add",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },
    {
        path: "/admin/social-links-update/:id",
        component: addUpdateSocialLinks,
        name: "social-links-update",
        meta: {
            NoLoginRequired: false,
            ClientLoginRequired: false,
            FreelancerLoginRequired: false,
            adminLoginRequired: true
        }
    },

]
const router = new VueRouter({
    routes, // short for `routes: routes`
    mode: "history",
    linkActiveClass: "active",
    scrollBehavior() {
        return { x: 0, y: 0 }
    }
});

router.beforeEach((to, from, next) => {
    /** CASE@  if user not login and try to access Client dashboaard protected path*/
    if (to.meta.ClientLoginRequired && !isLoggedIn() && to.name !== 'home') {
        const logoutError = "Authorization failed. You need to be logged in view this page.";
        router.push({ name: 'home', params: { logoutError: logoutError } });
    }
    /** CASE@  if user not login and try to access Freelancer dashboaard protected path*/
    else if (to.meta.FreelancerLoginRequired && !isLoggedIn() && to.name !== 'home') {
        const logoutError = "Authorization failed. You need to be logged in view this page.";
        router.push({ name: 'home', params: { logoutError: logoutError } });
    }
    /** CASE@  if client login and try to access Freelancer protected path*/
    else if (to.meta.FreelancerLoginRequired && isLoggedIn() && userRole() == 'client' && (to.name == 'freelance-profile' || to.name == 'freelance-profile-update' || to.name == 'freelance-subscribed-companies' || to.name == 'freelance-applied-applied' || to.name == 'freelance-reset-password')) {
        const logoutError = "Authorization failed. You need to be logged in as an Freelancer to view this page.";
        router.push({ name: 'create-service', params: { logoutError: logoutError } });
    }
    /** CASE@  if Freelancer login and try to access Client protected path*/
    else if (to.meta.ClientLoginRequired && isLoggedIn() && userRole() == 'freelancer' && (to.name == 'create-service' || to.name == 'reset-password' || to.name == 'update-profile' || to.name == 'clientListServices' || to.name == 'updateClientService' || to.name == 'cancel-subscription' || to.name == 'subscriptionPlans')) {
        const logoutError = "Authorization failed. You need to be logged in as an Client to view this page.";
        router.push({ name: 'freelance-profile', params: { logoutError: logoutError } });
    }
    /** CASE@  if admin not login and try to access Client dashboaard protected path*/
    else if (to.meta.adminLoginRequired && !isloginAdmin()) {
        const logoutError = "Authorization failed. You need to be logged in view this page.";
        router.push({ name: 'home', params: { logoutError: logoutError } });
    }
    /** CASE@  if admin login and try to access Client and protected path*/
    else if (to.meta.ClientLoginRequired && isloginAdmin() && (to.name == 'create-service' || to.name == 'reset-password' || to.name == 'update-profile' || to.name == 'clientListServices' || to.name == 'updateClientService' || to.name == 'cancel-subscription' || to.name == 'subscriptionPlans')) {
        const logoutError = "Authorization failed. You need to be logged in as an Client to view this page.";
        router.push({ name: 'freelance-profile', params: { logoutError: logoutError } });
    }
    /** CASE@  if admin login and try to access Freelancer protected path*/
    else if (to.meta.FreelancerLoginRequired && isloginAdmin() && (to.name == 'freelance-profile' || to.name == 'freelance-profile-update' || to.name == 'freelance-subscribed-companies' || to.name == 'freelance-applied-applied' || to.name == 'freelance-reset-password')) {
        const logoutError = "Authorization failed. You need to be logged in as an Freelancer to view this page.";
        router.push({ name: 'create-service', params: { logoutError: logoutError } });
    }
    /** CASE@ If Freelancer/client is loggedin and try to access the Signup page*/
    else if (isLoggedIn() && (to.name == 'freelancerSignUp' || to.name == 'clientSignup')) {
        if (userRole() == 'client') {
            router.push({ name: 'create-service', params: {} });
        }
        if (userRole() == 'freelancer') {
            router.push({ name: 'freelance-profile', params: {} });
        }
    }
    /** CASE@ If admin is loggedin and try to access the Signup page*/
    else if (isloginAdmin() && (to.name == 'freelancerSignUp' || to.name == 'clientSignup')) {
        router.push({ name: 'admin-listed-services', params: {} });
    }
    else {
        next();
    }
});

export default router;