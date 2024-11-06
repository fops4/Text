// analyze.js
const { genAI } = require('votre-module-genAI'); // Assurez-vous d'importer le bon module

const code = process.argv[2];

async function main() {
    try {
        const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });
        const prompt = `Veuillez examiner le code suivant et fournir des suggestions d'amélioration. Répond uniquement en français :\n\n${code}`;

        const result = await model.generateContent(prompt);
        const response = await result.response;

        // Retournez les suggestions ou un message par défaut
        console.log(response.text() || 'Aucune suggestion d\'amélioration disponible.');
    } catch (error) {
        console.error('Erreur lors de l\'analyse :', error);
        process.exit(1);
    }
}

main();