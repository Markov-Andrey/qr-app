<template>
    <div class="flex items-center justify-center w-full h-screen bg-gray-200">
        <v-card class="p-6 w-full max-w-md rounded-lg border-2 border-b-gray-300 border-transparent
            hover:outline hover:outline-2 hover:outline-green-500
            hover:shadow-[0_5px_0_0_#10b981]
            transition-all duration-300 ease-in-out"
        >
            <v-card-title class="text-center text-h6 text-md-h5 text-lg-h4">Login</v-card-title>

            <v-card-text>
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-text-field
                        v-model="email"
                        label="Email"
                        type="email"
                        :rules="emailRules"
                        required
                        outlined
                        class="mb-4 email-field"
                    />

                    <v-text-field
                        v-model="password"
                        label="Password"
                        type="password"
                        :rules="passwordRules"
                        required
                        outlined
                        class="mb-4 password-field"
                    />
                </v-form>
            </v-card-text>

            <v-card-actions>
                <v-spacer />
                <v-btn
                    :disabled="!valid"
                    color="teal-lighten-1"
                    variant="tonal"
                    @click="submit"
                >
                    Login
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: '',
            valid: false,
            emailRules: [
                (v) => !!v || 'Email is required',
                (v) => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            passwordRules: [
                (v) => !!v || 'Password is required',
                (v) => v.length >= 3 || 'Password must be at least 3 characters long',
            ],
        };
    },
    methods: {
        submit() {
            alert('Login attempt!');
        },
    },
};
</script>

<style scoped>
</style>
