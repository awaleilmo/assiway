export default function convertToBase64 (file) {
    file = file.target.files[0]
    return new Promise((resolve, reject) => {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(file);
        fileReader.onload = () => {
            resolve(fileReader.result);
        }
        fileReader.onerror = (error) => {
            reject(error);
        }
    });
}

export const formatter = new Intl.NumberFormat('id-ID');
