<script>
    function resumeBuilder(existingResume, defaultData, colorSchemes) {
        return {
            resume: {
                id: existingResume?.id || null,
                name: existingResume?.name || 'My Resume',
                template: existingResume?.template || 'professional',
                color_scheme: existingResume?.color_scheme || 'blue',
                photo_url: existingResume?.photo_url || '',
                full_name: existingResume?.full_name || defaultData?.full_name || '',
                job_title: existingResume?.job_title || '',
                email: existingResume?.email || defaultData?.email || '',
                phone: existingResume?.phone || defaultData?.phone || '',
                location: existingResume?.location || defaultData?.location || '',
                website: existingResume?.website || '',
                linkedin: existingResume?.linkedin || '',
                github: existingResume?.github || '',
                summary: existingResume?.summary || '',
                experience: existingResume?.experience || [],
                education: existingResume?.education || [],
                skills: existingResume?.skills || [],
                languages: existingResume?.languages || [],
                certifications: existingResume?.certifications || [],
                projects: existingResume?.projects || [],
            },
            templates: @json(\App\Models\Resume::getAvailableTemplates()),
            colorSchemes: colorSchemes,
            sections: {
                personal: true,
                summary: true,
                experience: true,
                education: true,
                skills: true,
                languages: false,
                certifications: false,
                projects: false,
            },
            mobileView: 'editor',
            saving: false,
            lastSaved: null,
            autosaveTimeout: null,

            init() {
                // Auto-save on changes
                this.$watch('resume', () => {
                    this.triggerAutosave();
                }, { deep: true });
            },

            toggleSection(section) {
                this.sections[section] = !this.sections[section];
            },

            // Experience
            addExperience() {
                this.resume.experience.push({
                    title: '',
                    company: '',
                    location: '',
                    start_date: '',
                    end_date: '',
                    description: ''
                });
            },
            removeExperience(index) {
                this.resume.experience.splice(index, 1);
                this.triggerAutosave();
            },

            // Education
            addEducation() {
                this.resume.education.push({
                    degree: '',
                    school: '',
                    start_date: '',
                    end_date: '',
                    gpa: ''
                });
            },
            removeEducation(index) {
                this.resume.education.splice(index, 1);
                this.triggerAutosave();
            },

            // Skills
            addSkill(skill) {
                if (skill && skill.trim() !== '') {
                    this.resume.skills.push({ name: skill.trim() });
                    this.triggerAutosave();
                }
            },
            removeSkill(index) {
                this.resume.skills.splice(index, 1);
                this.triggerAutosave();
            },

            // Languages
            addLanguage() {
                this.resume.languages.push({ name: '', level: 'intermediate' });
            },
            removeLanguage(index) {
                this.resume.languages.splice(index, 1);
                this.triggerAutosave();
            },

            // Certifications
            addCertification() {
                this.resume.certifications.push({ name: '', issuer: '', date: '' });
            },
            removeCertification(index) {
                this.resume.certifications.splice(index, 1);
                this.triggerAutosave();
            },

            // Photo Upload
            async uploadPhoto(event) {
                const file = event.target.files[0];
                if (!file) return;

                // Preview immediately
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.resume.photo_url = e.target.result;
                };
                reader.readAsDataURL(file);

                // Upload if resume exists
                if (this.resume.id) {
                    const formData = new FormData();
                    formData.append('photo', file);

                    try {
                        const response = await fetch(`/resume/${this.resume.id}/photo`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: formData
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.resume.photo_url = data.photo_url;
                        }
                    } catch (error) {
                        console.error('Photo upload failed:', error);
                    }
                }
            },

            async removePhoto() {
                if (this.resume.id) {
                    try {
                        await fetch(`/resume/${this.resume.id}/photo`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            }
                        });
                    } catch (error) {
                        console.error('Photo removal failed:', error);
                    }
                }
                this.resume.photo_url = '';
            },

            // Autosave
            triggerAutosave() {
                if (this.autosaveTimeout) {
                    clearTimeout(this.autosaveTimeout);
                }
                this.autosaveTimeout = setTimeout(() => {
                    if (this.resume.id) {
                        this.autosave();
                    }
                }, 2000);
            },

            async autosave() {
                if (!this.resume.id) return;

                try {
                    const response = await fetch(`/resume/${this.resume.id}/autosave`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify(this.resume)
                    });
                    const data = await response.json();
                    if (data.success) {
                        this.lastSaved = data.saved_at;
                    }
                } catch (error) {
                    console.error('Autosave failed:', error);
                }
            },

            // Save Resume
            async saveResume() {
                this.saving = true;

                const url = this.resume.id ? `/resume/${this.resume.id}` : '/resume';
                const method = this.resume.id ? 'PUT' : 'POST';

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(this.resume)
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.resume.id = data.resume.id;
                        this.lastSaved = new Date().toLocaleTimeString();
                        
                        // Update URL if new resume
                        if (!window.location.pathname.includes(data.resume.id)) {
                            window.history.replaceState({}, '', `/resume/${data.resume.id}/edit`);
                        }
                    }
                } catch (error) {
                    console.error('Save failed:', error);
                    alert('Failed to save resume. Please try again.');
                } finally {
                    this.saving = false;
                }
            },

            // Download PDF
            downloadPDF() {
                // Save first if needed
                if (this.resume.id) {
                    this.saveResume().then(() => {
                        window.open(`/resume/${this.resume.id}/download`, '_blank');
                    });
                } else {
                    // Save first, then download
                    this.saveResume().then(() => {
                        if (this.resume.id) {
                            window.open(`/resume/${this.resume.id}/download`, '_blank');
                        }
                    });
                }
            }
        }
    }
</script>
