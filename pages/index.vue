<template>
    <div class="flex items-center justify-center w-full h-screen">
        <v-card class="p-6 w-full max-w-md">
            <v-card-title class="text-center text-lg font-bold">Login</v-card-title>

            <v-card-text>
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-text-field
                        v-model="email"
                        label="Email"
                        type="email"
                        :rules="emailRules"
                        required
                        outlined
                        class="w-full mb-4"
                    />

                    <v-text-field
                        v-model="password"
                        label="Password"
                        type="password"
                        :rules="passwordRules"
                        required
                        outlined
                        class="w-full mb-4"
                    />

                    <v-alert
                        v-if="errorMessage"
                        type="error"
                        class="mt-2"
                        dense
                    >
                        {{ errorMessage }}
                    </v-alert>
                </v-form>
            </v-card-text>

            <v-card-actions>
                <v-spacer />
                <v-btn
                    :disabled="!valid"
                    color="primary"
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
            errorMessage: '',
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
            if (this.email === 'admin@example.com' && this.password === 'password') {
                alert('Login Successful!');
                this.errorMessage = '';
            } else {
                this.errorMessage = 'Invalid email or password';
            }
        },
    },
};
</script>

<style scoped>
</style>
