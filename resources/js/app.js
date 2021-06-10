/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vuelidate from "vuelidate";
import vSelect from "vue-select";
import Vue from "vue";

Vue.use(Vuelidate);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// vue-select
Vue.component("v-select", vSelect);

// courses
Vue.component('course-data-table', require('./components/course/CourseDataTable.vue').default);

// subjects
Vue.component('subject-data-table', require('./components/subject/SubjectDataTable.vue').default);

// instructors
Vue.component('instructor-data-table', require('./components/instructor/InstructorDataTable.vue').default);
Vue.component('new-instructor-form', require('./components/instructor/NewInstructorForm.vue').default);
Vue.component('tag-subjects-form', require('./components/instructor/TagSubjects.vue').default);

// instructor_subjects
Vue.component('instructor-subjects-data-table', require('./components/instructor_subjects/InstructorSubjectsDataTable.vue').default);
Vue.component('student-list', require('./components/instructor_subjects/StudentList.vue').default);

// registrars
Vue.component('registrar-data-table', require('./components/registrar/RegistrarDataTable.vue').default);
Vue.component('new-registrar-form', require('./components/registrar/NewRegistrarForm.vue').default);

// students
Vue.component('students-data-table', require('./components/students/StudentsDataTable.vue').default);
Vue.component('new-student-form', require('./components/students/NewStudentForm.vue').default);
Vue.component('student-grades', require('./components/students/StudentGrades.vue').default);
Vue.component('edit-academics', require('./components/students/EditAcademics.vue').default);
Vue.component('add-subjects', require('./components/students/AddSubjects.vue').default);

// curriculum
Vue.component('curriculum-data-table', require('./components/curriculum/CurriculumDataTable.vue').default);
Vue.component('new-curriculum-form', require('./components/curriculum/NewCurriculumForm.vue').default);
Vue.component('add-subjects-form', require('./components/curriculum/AddSubjectsForm.vue').default);
Vue.component('curriculum-tabs', require('./components/curriculum/CurriculumTabs.vue').default);

// academic_year
Vue.component('academic-data-table', require('./components/academicYear/AcademicYearDataTable.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.addEventListener("load", function() {
    const app = new Vue({
        el: "#app"
    });
});
