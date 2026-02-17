
### **1. Tech Fair Challenge**
A short, self-contained challenge meant for visitors who received a physical card at the fair.

- **Hint on card:** encoded path leading to `/fair-secrets`.  
- **Hidden reward:** a playful congratulatory page with a reference to the evergreen challenge.

### **2. Evergreen Secrets Hunter Challenge**
A deeper, multi-stage puzzle available from the main site.

| Step | Discovery Method                                       | Flag                    |
| :--: | ------------------------------------------------------ | ----------------------- |
|  1   | DNS TXT record on `_flag.giedriussec.lt`               | `FLAG{dn5-exp3rt}`      |
|  2   | Custom HTTP header on `/challenge`                     | `FLAG{h3ader-hunt3r}`   |
|  3   | Base64-encoded flag + ROT13 clue leading to `/gateway` | `FLAG{dec0ding-ma5ter}` |
|  4   | Entering all 3 flags to `/gateway`                     | `FLAG{s3cret5-hunt3r}`  |

The final route greeted solvers with a “Congratulations” message and links to my résumé and contact information — transforming curiosity into a potential professional connection.

---

## Example Recruiter Flow

1. A recruiter or engineer visits the site and notices the *“Secrets Hunter Challenge”* button.  
2. The modal text drops the hint: *“Sometimes the truth lies in TXT.”*  
3. Looking up DNS TXT records reveals the first flag and the next step.  
4. Exploring `/challenge` uncovers special HTTP headers with the second flag, Base64 encoded third flag and a ROT13 hint.  
5. Decoding the hint leads to the final stage and reward page.  

Each step intentionally mirrors investigative thinking — the same mindset used in threat hunting or penetration testing.
