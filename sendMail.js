const nodemailer = require('nodemailer');
const axios = require('axios');
const { GoogleGenerativeAI } = require("@google/generative-ai");
require('dotenv').config();
const { execSync } = require('child_process');

// Fonction pour récupérer l'utilisateur GitHub
function getGithubUser() {
    try {
      const gitConfigUser = execSync('git config user.name').toString().trim();
      const gitConfigEmail = execSync('git config user.email').toString().trim();
      return { name: gitConfigUser, email: gitConfigEmail };
    } catch (error) {
      console.error('Erreur lors de la récupération des informations Git:', error);
      return null;
    }
}

// Créer une instance de Gemini
const genAI = new GoogleGenerativeAI(process.env.GEMINI_API_KEY);

// Fonction pour récupérer les détails du dernier commit
function getCommitDetails() {
    const commitMessage = execSync('git log -1 --pretty=format:"%s"').toString().trim();
    const author = execSync('git log -1 --pretty=format:"%an <%ae>"').toString().trim();
    return { commitMessage, author };
}

// Fonction pour récupérer les modifications du dernier commit
function getDiff() {
    return execSync('git diff HEAD~1 HEAD').toString();
}

// Fonction pour analyser le code via Gemini
async function analyzeCodeWithGemini(code) {
    const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });
    const prompt = `Veuillez examiner le code suivant et fournir des suggestions d'amélioration. Répond uniquement en français :\n\n${code}`;

    const result = await model.generateContent(prompt);
    const response = await result.response;

    return response.text() || 'Aucune suggestion d\'amélioration disponible.';
}

// Fonction principale
async function main() {
    const { commitMessage, author } = getCommitDetails();
    const diff = getDiff();

    console.log('Dernier commit par :', author);
    console.log('Message du commit :', commitMessage);
    console.log('Différences du dernier commit :', diff);

    if (!diff.trim()) {
        console.log('Aucune modification de code à analyser.');
        return;
    }

    const geminiSuggestions = await analyzeCodeWithGemini(diff);
    console.log('Suggestions d\'amélioration :', geminiSuggestions);

    await sendEmail(commitMessage, geminiSuggestions);
}

// Fonction pour envoyer l'e-mail
async function sendEmail(commitMessage, geminiSuggestions) {
    const user = getGithubUser();
    if (!user) return;

    const transporter = nodemailer.createTransport({
        service: 'gmail',
        auth: {
            user: 'fops415@gmail.com',
            pass: 'wzrq uhqj iekx irpn'
        }
    });

    const mailOptions = {
        from: '"Notifier de Commit" <fops415@gmail.com>',
        to: user.email, // Email de l'utilisateur GitHub
        subject: 'Nouveau Commit effectué',
        text: `Bonjour ${user.name},\n\nVous avez effectué un nouveau commit :\n\n"${commitMessage}"\n\nMerci !\n\nComme suggestion :\n\n"${geminiSuggestions}"\n\n`,
    };

    try {
        await transporter.sendMail(mailOptions);
        console.log('E-mail envoyé avec succès');
    } catch (error) {
        console.error('Erreur lors de l\'envoi de l\'e-mail:', error);
    }
}

// Exécuter le script principal
main();
