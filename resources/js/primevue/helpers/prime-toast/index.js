import { useToast } from 'primevue/usetoast';

const _toastInfo = {
    _toast: null,
    get toast() {
        if (!this._toast) {
            this._toast = useToast();
        }

        return this._toast;
    }
}

export const toastIt = (message, type = 'info', life = null, options = {}) => {
    if (typeof message !== 'string') {
        return;
    }

    options = typeof options === 'object' && !Array.isArray(options) ? options : {};

    life = life ?? options['life'] ?? null;
    life = !isNaN(parseInt(life)) ? parseInt(life) : 5000;

    life = parseInt(life) >= 0 ? parseInt(life) : null;

    type = type ?? options['severity'] ?? options['type'] ?? 'info';
    type = typeof type === 'string' ? type : 'info';

    let summary = options['summary'] ?? options['title'] ?? 'info';
    summary = typeof summary === 'string' ? summary : null;

    let severity = options['severity'] ?? options['type'] ?? type;
    severity = typeof severity === 'string' ? severity : type;


    options = {
        ...options,
        life,
        severity,
        summary,
        detail: message,
    }

    return _toastInfo?.toast?.add(options);
}

export const toast = (message, type = 'info', life = null, options = {}) => toastIt(message, type, life, options);

const success = (message, life = null, options = {}) => {
    toastIt(message, 'success', life, { ...options, severity: 'success', detail: message, life });
};

const info = (message, life = null, options = {}) => {
    toastIt(message, 'info', life, { ...options, severity: 'info', detail: message, life });
};

const warn = (message, life = null, options = {}) => {
    toastIt(message, 'warn', life, { ...options, severity: 'warn', detail: message, life });
};

const error = (message, life = null, options = {}) => {
    toastIt(message, 'error', life, { ...options, severity: 'error', detail: message, life });
};

const secondary = (message, life = null, options = {}) => {
    toastIt(message, 'secondary', life, { ...options, severity: 'secondary', detail: message, life });
};

const contrast = (message, life = null, options = {}) => {
    toastIt(message, 'contrast', life, { ...options, severity: 'contrast', detail: message, life });
};

export default {
    toast: toastIt,
    toastIt,
    info,
    success,
    info,
    warn,
    error,
    secondary,
    contrast,
};
