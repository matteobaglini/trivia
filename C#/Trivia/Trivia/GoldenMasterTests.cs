using System;
using System.IO;
using Xunit;

namespace Trivia
{
    public class GoldenMasterTests
    {
        const string GoldenMasterFileName = "golden_master.txt";
        const int RunTimes = 1000;

        public GoldenMasterTests()
        {
            if (File.Exists(GoldenMasterFileName)) return;
            GenerateGoldenMaster();
        }

        [Fact]
        public void MultipleTriviaRuns()
        {
            var goldenMaster = ReadGoldenMaster();
            var output = MultipleRunsOutput();

            Assert.Equal(goldenMaster, output);
        }

        static string MultipleRunsOutput()
        {
            return CaptureConsoleOutput(MultipleRuns);
        }

        static void GenerateGoldenMaster()
        {
            File.WriteAllText(GoldenMasterFileName, MultipleRunsOutput());
        }

        static string ReadGoldenMaster()
        {
            return File.ReadAllText(GoldenMasterFileName);
        }

        static string CaptureConsoleOutput(Action action)
        {
            var currentOut = Console.Out;
            string result;

            using (var writer = new StringWriter())
            {
                Console.SetOut(writer);
                action();
                writer.Flush();
                result = writer.ToString();
            }
            Console.SetOut(currentOut);
            return result;
        }

        static void MultipleRuns()
        {
            for (var seed = 0; seed < RunTimes; seed++)
                GameRunner.Run(new Random(seed));
        }
    }
}