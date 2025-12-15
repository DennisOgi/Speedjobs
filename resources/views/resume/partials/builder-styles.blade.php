<style>
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }

    /* Alpine.js collapse transition */
    [x-cloak] { display: none !important; }

    /* Print Styles */
    @media print {
        @page {
            size: A4;
            margin: 0;
        }
        body * {
            visibility: hidden;
        }
        #resume-preview, #resume-preview * {
            visibility: visible;
        }
        #resume-preview {
            position: absolute;
            left: 0;
            top: 0;
            width: 210mm;
            min-height: 297mm;
            max-width: 210mm;
            margin: 0;
            padding: 0;
            box-shadow: none !important;
            transform: none !important;
            border-radius: 0 !important;
        }
        /* Ensure backgrounds print */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }

    /* Resume Preview Container */
    #resume-preview {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Template-specific fonts */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap');

    /* Ensure proper line heights in preview */
    #resume-preview p {
        line-height: 1.6;
    }

    /* Fix for template backgrounds */
    #resume-preview .bg-slate-900 {
        background-color: #0f172a !important;
    }

    /* Animation for save indicator */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }
</style>
