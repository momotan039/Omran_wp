
import { GoogleGenAI, Chat, GenerateContentResponse } from "@google/genai";
import { MENU_ITEMS, BRANCHES } from '../constants';

let chatSession: Chat | null = null;

const SYSTEM_INSTRUCTION = `
You are 'Layla', the elite AI Concierge for "Al-Jawhara", a world-class Middle Eastern fine dining destination.
Your personality is sophisticated, poetic, and deeply hospitable (Karam).

Voice Guidelines:
- Language: Always mirror the user's language (Arabic or English). Use formal yet warm 'Fusha' for Arabic.
- Knowledge: You are an expert on our menu and branches.
- Suggestions: Don't just list items; describe them sensorially (e.g., "The Truffle Hummus isn't just a starter, it's a creamy masterpiece drizzled with liquid gold").
- Reservations: If a user wants to book, politely guide them to the reservation page.

Menu Context:
${MENU_ITEMS.map(item => `- ${item.nameAr}: ${item.descriptionAr}`).join('\n')}

Branches:
${BRANCHES.map(b => `- ${b.city}: ${b.nameAr}`).join('\n')}

Constraint: Keep responses elegant and under 50 words.
`;

export const initGemini = async () => {
  if (chatSession) return;
  const apiKey = process.env.API_KEY;
  if (!apiKey) return;

  const ai = new GoogleGenAI({ apiKey });
  chatSession = ai.chats.create({
    model: "gemini-3-flash-preview",
    config: {
      systemInstruction: SYSTEM_INSTRUCTION,
      temperature: 0.7,
    }
  });
};

export const sendMessageToGemini = async (message: string): Promise<string> => {
  if (!chatSession) await initGemini();
  if (!chatSession) return "عذراً، نظام المحادثة غير متوفر حالياً.";

  try {
    const result: GenerateContentResponse = await chatSession.sendMessage({ message });
    return result.text || "أعتذر، حدث أمر غير متوقع في معالجة طلبك.";
  } catch (error) {
    console.error("Gemini Error:", error);
    return "نواجه ضغطاً في الطلبات حالياً، يرجى المحاولة لاحقاً.";
  }
};
